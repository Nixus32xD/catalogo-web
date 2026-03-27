<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::query()->get()->keyBy('name');

        collect([
            ['name' => 'Producto destacado esencial', 'category' => 'Destacados', 'price' => 18500, 'sort_order' => 1, 'is_featured' => true],
            ['name' => 'Producto premium de muestra', 'category' => 'Destacados', 'price' => 24900, 'sort_order' => 2, 'is_featured' => true],
            ['name' => 'Nueva propuesta comercial', 'category' => 'Novedades', 'price' => 15800, 'sort_order' => 3, 'is_featured' => true],
            ['name' => 'Opcion recomendada', 'category' => 'Novedades', 'price' => 12990, 'sort_order' => 4, 'is_featured' => false],
            ['name' => 'Producto base uno', 'category' => 'Linea principal', 'price' => 9800, 'sort_order' => 5, 'is_featured' => false],
            ['name' => 'Producto base dos', 'category' => 'Linea principal', 'price' => 11450, 'sort_order' => 6, 'is_featured' => false],
            ['name' => 'Producto base tres', 'category' => 'Linea principal', 'price' => 14300, 'sort_order' => 7, 'is_featured' => true],
            ['name' => 'Complemento sugerido', 'category' => 'Complementos', 'price' => 6900, 'sort_order' => 8, 'is_featured' => false],
            ['name' => 'Complemento premium', 'category' => 'Complementos', 'price' => 8450, 'sort_order' => 9, 'is_featured' => false],
            ['name' => 'Edicion comercial demo', 'category' => 'Destacados', 'price' => 27800, 'sort_order' => 10, 'is_featured' => true],
        ])->each(function (array $product) use ($categories): void {
            $category = $categories->get($product['category']);

            Product::query()->updateOrCreate(
                ['name' => $product['name']],
                [
                    'category_id' => $category?->id,
                    'short_description' => 'Descripcion corta generica para mostrar como se presentaria este producto dentro del catalogo publico del comercio.',
                    'price' => $product['price'],
                    'sort_order' => $product['sort_order'],
                    'is_featured' => $product['is_featured'],
                    'is_active' => true,
                ],
            );
        });
    }
}
