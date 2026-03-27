<?php

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\BusinessProfileSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\StoreLocationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('storefront landing and catalog render demo content', function () {
    $this->seed([
        BusinessProfileSeeder::class,
        CategorySeeder::class,
        ProductSeeder::class,
        StoreLocationSeeder::class,
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Nombre del comercio')
        ->assertSee('Producto destacado esencial')
        ->assertSee('Sucursal Maipu Centro');

    $this->get('/catalogo?search=premium')
        ->assertOk()
        ->assertSee('Producto premium de muestra');

    $product = Product::query()->where('name', 'Producto destacado esencial')->firstOrFail();
    $expectedProductMessage = rawurlencode("Hola, quiero consultar por {$product->name} de Nombre del comercio.");

    $this->get('/contacto')
        ->assertOk()
        ->assertSee('Sucursal Lulunta')
        ->assertSee('Abrir mapa principal');

    $this->get('/catalogo')
        ->assertOk()
        ->assertSee($expectedProductMessage, false);
});

test('catalog route accepts category filters', function () {
    $this->seed([
        BusinessProfileSeeder::class,
        CategorySeeder::class,
        ProductSeeder::class,
    ]);

    $category = Category::query()->where('name', 'Complementos')->firstOrFail();

    $this->get('/catalogo?category='.$category->slug)
        ->assertOk()
        ->assertSee('Todos los productos');
});
