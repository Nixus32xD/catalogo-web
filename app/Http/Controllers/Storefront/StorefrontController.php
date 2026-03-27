<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function home(): View
    {
        $profile = BusinessProfile::current()->load([
            'locations' => fn ($query) => $query->active()->ordered(),
        ]);

        $featuredProducts = Product::query()
            ->with('category')
            ->active()
            ->featured()
            ->ordered()
            ->take(4)
            ->get();

        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::query()
                ->with('category')
                ->active()
                ->ordered()
                ->take(4)
                ->get();
        }

        return view('storefront.home', [
            'profile' => $profile,
            'featuredProducts' => $featuredProducts,
            'categories' => Category::query()->active()->ordered()->take(6)->get(),
        ]);
    }

    public function catalog(Request $request): View
    {
        $categories = Category::query()->active()->ordered()->get();
        $selectedCategory = $categories->firstWhere('slug', $request->string('category')->toString());
        $search = $request->string('search')->toString();

        $products = Product::query()
            ->with('category')
            ->active()
            ->when($selectedCategory, fn ($query) => $query->whereBelongsTo($selectedCategory, 'category'))
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        $featuredProducts = Product::query()
            ->with('category')
            ->active()
            ->featured()
            ->ordered()
            ->take(4)
            ->get();

        return view('storefront.catalog', [
            'categories' => $categories,
            'products' => $products,
            'featuredProducts' => $featuredProducts,
            'selectedCategory' => $selectedCategory,
            'search' => $search,
        ]);
    }

    public function contact(): View
    {
        $profile = BusinessProfile::current()->load([
            'locations' => fn ($query) => $query->active()->ordered(),
        ]);

        return view('storefront.contact', [
            'profile' => $profile,
            'featuredProducts' => Product::query()
                ->with('category')
                ->active()
                ->featured()
                ->ordered()
                ->take(3)
                ->get(),
        ]);
    }
}
