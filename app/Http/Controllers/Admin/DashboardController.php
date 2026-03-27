<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $profile = BusinessProfile::current();

        return view('admin.dashboard', [
            'profile' => $profile,
            'recentProducts' => Product::query()->with('category')->latest()->take(5)->get(),
            'stats' => [
                'active_products' => Product::query()->active()->count(),
                'featured_products' => Product::query()->featured()->count(),
                'active_categories' => Category::query()->active()->count(),
                'active_locations' => $profile->locations()->active()->count(),
                'profile_completion' => $this->profileCompletion($profile),
            ],
        ]);
    }

    protected function profileCompletion(BusinessProfile $profile): int
    {
        $fields = [
            $profile->business_name,
            $profile->short_description,
            $profile->address,
            $profile->whatsapp,
            $profile->phone,
            $profile->email,
            $profile->business_hours,
            $profile->welcome_text,
            $profile->primary_color,
            $profile->secondary_color,
        ];

        $filledFields = collect($fields)->filter(fn ($value) => filled($value))->count();

        return (int) round(($filledFields / count($fields)) * 100);
    }
}
