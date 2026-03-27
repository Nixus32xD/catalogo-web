<?php

use App\Http\Controllers\Admin\BusinessProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StoreLocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Storefront\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/catalogo', [StorefrontController::class, 'catalog'])->name('catalog.index');
Route::get('/contacto', [StorefrontController::class, 'contact'])->name('contact');

Route::middleware('auth')->group(function () {
    Route::redirect('/dashboard', '/admin')->name('dashboard');
    Route::get('/admin', DashboardController::class)->name('admin.dashboard');
    Route::resource('/admin/categorias', CategoryController::class)
        ->except('show')
        ->names('admin.categories');
    Route::resource('/admin/productos', ProductController::class)
        ->except('show')
        ->names('admin.products');
    Route::resource('/admin/sucursales', StoreLocationController::class)
        ->except('show')
        ->names('admin.locations')
        ->parameters(['sucursales' => 'location']);
    Route::get('/admin/configuracion', [BusinessProfileController::class, 'edit'])
        ->name('admin.business-profile.edit');
    Route::put('/admin/configuracion', [BusinessProfileController::class, 'update'])
        ->name('admin.business-profile.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
