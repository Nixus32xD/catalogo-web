<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesPublicUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BusinessProfileRequest;
use App\Models\BusinessProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BusinessProfileController extends Controller
{
    use HandlesPublicUploads;

    public function edit(): View
    {
        return view('admin.settings.edit', [
            'profile' => BusinessProfile::current(),
        ]);
    }

    public function update(BusinessProfileRequest $request): RedirectResponse
    {
        $profile = BusinessProfile::current();

        $data = $request->safe()->except([
            'logo',
            'hero_image',
            'remove_logo',
            'remove_hero_image',
        ]);

        if ($request->boolean('remove_logo')) {
            $this->deletePublicFile($profile->logo_path);
            $data['logo_path'] = null;
        }

        if ($request->boolean('remove_hero_image')) {
            $this->deletePublicFile($profile->hero_image_path);
            $data['hero_image_path'] = null;
        }

        if ($request->hasFile('logo')) {
            $this->deletePublicFile($profile->logo_path);
            $data['logo_path'] = $this->storePublicFile($request->file('logo'), 'business');
        }

        if ($request->hasFile('hero_image')) {
            $this->deletePublicFile($profile->hero_image_path);
            $data['hero_image_path'] = $this->storePublicFile($request->file('hero_image'), 'business');
        }

        $profile->update($data);

        return redirect()
            ->route('admin.business-profile.edit')
            ->with('success', 'La configuracion del comercio fue actualizada.');
    }
}
