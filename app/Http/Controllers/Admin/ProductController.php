<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesPublicUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    use HandlesPublicUploads;

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();
        $categoryId = $request->integer('category_id');

        return view('admin.products.index', [
            'search' => $search,
            'status' => $status,
            'selectedCategoryId' => $categoryId,
            'categories' => Category::query()->active()->ordered()->get(),
            'products' => Product::query()
                ->with('category')
                ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                ->when($categoryId > 0, fn ($query) => $query->where('category_id', $categoryId))
                ->when($status === 'active', fn ($query) => $query->where('is_active', true))
                ->when($status === 'inactive', fn ($query) => $query->where('is_active', false))
                ->ordered()
                ->paginate(12)
                ->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => new Product([
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 0,
            ]),
            'categories' => Category::query()->active()->ordered()->get(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        Product::query()->create([
            ...$request->safe()->except(['image', 'is_active', 'is_featured']),
            'image_path' => $this->storePublicFile($request->file('image'), 'products'),
            'is_active' => $request->boolean('is_active', true),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $request->integer('sort_order', 0),
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $producto): View
    {
        return view('admin.products.edit', [
            'product' => $producto,
            'categories' => Category::query()->active()->ordered()->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $producto): RedirectResponse
    {
        $data = [
            ...$request->safe()->except(['image', 'is_active', 'is_featured']),
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $request->integer('sort_order', 0),
        ];

        if ($request->hasFile('image')) {
            $this->deletePublicFile($producto->image_path);
            $data['image_path'] = $this->storePublicFile($request->file('image'), 'products');
        }

        $producto->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $producto): RedirectResponse
    {
        $this->deletePublicFile($producto->image_path);
        $producto->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
