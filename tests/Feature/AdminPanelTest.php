<?php

use App\Models\BusinessProfile;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\BusinessProfileSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\StoreLocationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can access the admin dashboard', function () {
    $this->seed([
        BusinessProfileSeeder::class,
        CategorySeeder::class,
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertOk()
        ->assertSee('Panel de administracion')
        ->assertSee('Nombre del comercio')
        ->assertSee('Sucursales activas');
});

test('authenticated user can create products from the admin panel', function () {
    $this->seed([
        BusinessProfileSeeder::class,
        CategorySeeder::class,
    ]);

    $user = User::factory()->create();
    $category = Category::query()->firstOrFail();

    $response = $this->actingAs($user)->post('/admin/productos', [
        'category_id' => $category->id,
        'name' => 'Producto admin de prueba',
        'short_description' => 'Descripcion creada desde una prueba automatizada.',
        'price' => '19999',
        'sort_order' => 3,
        'is_active' => '1',
        'is_featured' => '1',
    ]);

    $response->assertRedirect(route('admin.products.index'));

    $this->assertDatabaseHas('products', [
        'name' => 'Producto admin de prueba',
        'category_id' => $category->id,
        'is_active' => true,
        'is_featured' => true,
    ]);
});

test('authenticated user can update the business profile', function () {
    $this->seed(BusinessProfileSeeder::class);

    $user = User::factory()->create();

    $response = $this->actingAs($user)->put('/admin/configuracion', [
        'business_name' => 'Comercio actualizado',
        'short_description' => 'Descripcion actualizada desde una prueba.',
        'address' => 'Nueva direccion 123',
        'whatsapp' => '+54 9 11 1111 1111',
        'phone' => '+54 11 2222 2222',
        'email' => 'nuevo@demo.local',
        'business_hours' => 'Lunes a viernes de 9:00 a 18:00',
        'welcome_text' => 'Bienvenida actualizada',
        'whatsapp_message' => 'Hola, quiero saber mas sobre {business_name}.',
        'product_inquiry_message' => 'Hola, quiero consultar por {product_name}.',
        'primary_color' => '#0f766e',
        'secondary_color' => '#f59e0b',
        'remove_logo' => '0',
        'remove_hero_image' => '0',
    ]);

    $response->assertRedirect(route('admin.business-profile.edit'));

    expect(BusinessProfile::current()->business_name)->toBe('Comercio actualizado');
    expect(BusinessProfile::current()->whatsapp_message)->toBe('Hola, quiero saber mas sobre {business_name}.');
    expect(BusinessProfile::current()->product_inquiry_message)->toBe('Hola, quiero consultar por {product_name}.');
});

test('authenticated user can create store locations from the admin panel', function () {
    $this->seed([
        BusinessProfileSeeder::class,
        StoreLocationSeeder::class,
    ]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/admin/sucursales', [
        'name' => 'Sucursal Chacras',
        'address' => 'Direccion de la sucursal Chacras',
        'whatsapp' => '+54 9 11 0000 0003',
        'phone' => '+54 11 0000 0003',
        'email' => 'chacras@demo.local',
        'business_hours' => 'Lunes a viernes de 8:30 a 17:30',
        'map_embed_url' => 'https://www.google.com/maps?q=Chacras%20de%20Coria&output=embed',
        'maps_url' => 'https://www.google.com/maps/search/?api=1&query=Chacras+de+Coria',
        'notes' => 'Sucursal pensada para entregas y retiro.',
        'sort_order' => 3,
        'is_active' => '1',
        'is_primary' => '0',
    ]);

    $response->assertRedirect(route('admin.locations.index'));

    $this->assertDatabaseHas('store_locations', [
        'name' => 'Sucursal Chacras',
        'address' => 'Direccion de la sucursal Chacras',
        'is_active' => true,
        'is_primary' => false,
    ]);
});
