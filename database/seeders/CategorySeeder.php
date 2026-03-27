<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        collect([
            ['name' => 'Destacados', 'description' => 'Productos o servicios clave para mostrar primero.', 'sort_order' => 1],
            ['name' => 'Novedades', 'description' => 'Ingresos recientes o propuestas nuevas.', 'sort_order' => 2],
            ['name' => 'Linea principal', 'description' => 'La oferta base del comercio.', 'sort_order' => 3],
            ['name' => 'Complementos', 'description' => 'Opciones adicionales para ampliar la venta.', 'sort_order' => 4],
        ])->each(function (array $category): void {
            Category::query()->updateOrCreate(
                ['name' => $category['name']],
                $category + ['is_active' => true],
            );
        });
    }
}
