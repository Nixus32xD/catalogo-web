<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        return view('admin.categories.index', [
            'search' => $search,
            'categories' => Category::query()
                ->withCount('products')
                ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                ->ordered()
                ->paginate(12)
                ->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new Category([
                'is_active' => true,
                'sort_order' => 0,
            ]),
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::query()->create([
            ...$request->safe()->except('is_active'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->integer('sort_order', 0),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoria creada correctamente.');
    }

    public function edit(Category $categoria): View
    {
        return view('admin.categories.edit', [
            'category' => $categoria,
        ]);
    }

    public function update(CategoryRequest $request, Category $categoria): RedirectResponse
    {
        $categoria->update([
            ...$request->safe()->except('is_active'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->integer('sort_order', 0),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoria actualizada correctamente.');
    }

    public function destroy(Category $categoria): RedirectResponse
    {
        if ($categoria->products()->exists()) {
            return back()->with('error', 'No se puede eliminar una categoria que tiene productos asociados.');
        }

        $categoria->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoria eliminada correctamente.');
    }
}
