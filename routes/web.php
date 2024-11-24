<?php

use App\Http\Controllers\ArchivoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedoreController;
use App\Http\Controllers\TallaController;
use App\Http\Controllers\VentaController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('vista');
});

Route::middleware(['auth'])->group(function () {
    Route::view('/panel', 'panel.index')->name('panel');

    Route::resources([
        'categorias' => CategoriaController::class,
        'marcas' => MarcaController::class,
        'productos' => ProductoController::class,
        'tallas' => TallaController::class,
        'clientes' => ClienteController::class,
        'proveedores' => ProveedoreController::class,
        'compras' => CompraController::class,
        'ventas' => VentaController::class,
        'perfil' => PerfilController::class,
    ]);
});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::post('/archivos/{modelType}/{modelId}', [ArchivoController::class, 'store'])->name('archivos.store');
Route::delete('/archivos/{archivo}', [ArchivoController::class, 'destroy'])->name('archivos.destroy');
Route::get('/archivos/{archivo}/download', [ArchivoController::class, 'download'])->name('archivos.download');

Route::get('/401', function () {
    return view('pages.401');
});

Route::get('/404', function () {
    return view('pages.404');
});

Route::get('/500', function () {
    return view('pages.500');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
