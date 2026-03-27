<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLocationRequest;
use App\Models\BusinessProfile;
use App\Models\StoreLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreLocationController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        return view('admin.locations.index', [
            'search' => $search,
            'locations' => BusinessProfile::current()
                ->locations()
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($nestedQuery) use ($search): void {
                        $nestedQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('address', 'like', "%{$search}%");
                    });
                })
                ->paginate(12)
                ->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.locations.create', [
            'location' => new StoreLocation([
                'is_active' => true,
                'is_primary' => BusinessProfile::current()->locations()->count() === 0,
                'sort_order' => 0,
            ]),
        ]);
    }

    public function store(StoreLocationRequest $request): RedirectResponse
    {
        $profile = BusinessProfile::current();

        $location = $profile->locations()->create($this->payload($request, $profile));
        $this->syncPrimaryLocation($profile, $location, $request->boolean('is_primary'));

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Sucursal creada correctamente.');
    }

    public function edit(StoreLocation $location): View
    {
        $location = $this->currentProfileLocation($location);

        return view('admin.locations.edit', [
            'location' => $location,
        ]);
    }

    public function update(StoreLocationRequest $request, StoreLocation $location): RedirectResponse
    {
        $profile = BusinessProfile::current();
        $location = $this->currentProfileLocation($location);

        $location->update($this->payload($request, $profile));
        $this->syncPrimaryLocation($profile, $location, $request->boolean('is_primary'));

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Sucursal actualizada correctamente.');
    }

    public function destroy(StoreLocation $location): RedirectResponse
    {
        $profile = BusinessProfile::current();
        $location = $this->currentProfileLocation($location);
        $wasPrimary = $location->is_primary;

        $location->delete();

        if ($wasPrimary) {
            $replacement = $profile->locations()->active()->ordered()->first()
                ?? $profile->locations()->ordered()->first();

            if ($replacement) {
                $profile->locations()->whereKeyNot($replacement->id)->update(['is_primary' => false]);
                $replacement->update(['is_primary' => true]);
            }
        }

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Sucursal eliminada correctamente.');
    }

    protected function payload(StoreLocationRequest $request, BusinessProfile $profile): array
    {
        return [
            ...$request->safe()->except(['is_primary', 'is_active']),
            'business_profile_id' => $profile->id,
            'sort_order' => $request->integer('sort_order', 0),
            'is_active' => $request->boolean('is_active', true),
            'is_primary' => $request->boolean('is_primary'),
        ];
    }

    protected function syncPrimaryLocation(BusinessProfile $profile, StoreLocation $location, bool $makePrimary): void
    {
        $locations = StoreLocation::query()
            ->whereBelongsTo($profile, 'businessProfile')
            ->ordered()
            ->get();

        if ($locations->isEmpty()) {
            return;
        }

        $primaryLocation = null;

        if ($makePrimary && $location->is_active) {
            $primaryLocation = $locations->firstWhere('id', $location->id);
        }

        $primaryLocation ??= $locations->first(function (StoreLocation $item): bool {
            return $item->is_primary && $item->is_active;
        });

        $primaryLocation ??= $locations->first(function (StoreLocation $item) use ($location): bool {
            return $item->id === $location->id && $item->is_active;
        });

        $primaryLocation ??= $locations->first(fn (StoreLocation $item): bool => $item->is_active);
        $primaryLocation ??= $locations->first();

        StoreLocation::query()
            ->whereBelongsTo($profile, 'businessProfile')
            ->update(['is_primary' => false]);

        if ($primaryLocation) {
            StoreLocation::query()
                ->whereKey($primaryLocation->id)
                ->update(['is_primary' => true]);
        }
    }

    protected function currentProfileLocation(StoreLocation $location): StoreLocation
    {
        abort_unless(
            $location->business_profile_id === BusinessProfile::current()->id,
            404,
        );

        return $location;
    }
}
