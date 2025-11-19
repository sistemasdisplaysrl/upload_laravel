<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AjusteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\AccountController;

Auth::routes();

// Raíz: si autenticado => /admin, si invitado => muestra login directamente
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.index');
    }
    return view('auth.login');
});

//Route::get('/', [AdminController::class, 'index'])->name('admin.index')->middleware('auth');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('auth');
Route::get('/admin/ajustes', [AjusteController::class, 'index'])->name('admin.ajustes.index')->middleware('auth');

Route::post('/admin/ajustes/create', [AjusteController::class, 'store'])->name('admin.ajustes.create')->middleware('auth');

//ruta para Roles (solo roles: Super Admin o Administrador)
Route::middleware([
    'auth',
    \Spatie\Permission\Middleware\RoleMiddleware::class . ':Super Admin|Administrador',
])->group(function () {
    Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/admin/roles/store', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/admin/roles/edit/{id}', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::put('/admin/roles/update/{id}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/admin/roles/destroy/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
});

//ruta para Usuarios (solo roles: Super Admin o Administrador)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':usuarios.view');

    Route::get('/admin/usuarios/create', [UsuarioController::class, 'create'])->name('admin.usuarios.create')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':usuarios.create');

    Route::post('/admin/usuarios/store', [UsuarioController::class, 'store'])->name('admin.usuarios.store')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':usuarios.create');

    Route::get('/admin/usuarios/edit/{id}', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':usuarios.edit');

    Route::put('/admin/usuarios/update/{id}', [UsuarioController::class, 'update'])->name('admin.usuarios.update')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':usuarios.edit');

    Route::delete('/admin/usuarios/destroy/{id}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':usuarios.delete');
});

//ruta para Cargos (solo roles: Super Admin o Administrador)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/cargos', [CargoController::class, 'index'])->name('admin.cargos.index')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':cargos.view');

    Route::get('/admin/cargos/create', [CargoController::class, 'create'])->name('admin.cargos.create')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':cargos.create');

    Route::post('/admin/cargos/store', [CargoController::class, 'store'])->name('admin.cargos.store')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':cargos.create');

    Route::get('/admin/cargos/edit/{id}', [CargoController::class, 'edit'])->name('admin.cargos.edit')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':cargos.edit');

    Route::put('/admin/cargos/update/{id}', [CargoController::class, 'update'])->name('admin.cargos.update')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':cargos.edit');

    Route::delete('/admin/cargos/destroy/{id}', [CargoController::class, 'destroy'])->name('admin.cargos.destroy')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':cargos.delete');
});

//ruta para Manuales (permisos por acción)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/manuales', [ManualController::class, 'index'])->name('admin.manuales.index')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':manuales.view');
    Route::get('/admin/manuales/create', [ManualController::class, 'create'])->name('admin.manuales.create')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':manuales.create');
    Route::post('/admin/manuales/store', [ManualController::class, 'store'])->name('admin.manuales.store')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':manuales.create');
    Route::get('/admin/manuales/edit/{manual}', [ManualController::class, 'edit'])->name('admin.manuales.edit')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':manuales.edit');
    Route::put('/admin/manuales/update/{manual}', [ManualController::class, 'update'])->name('admin.manuales.update')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':manuales.edit');
    Route::delete('/admin/manuales/destroy/{manual}', [ManualController::class, 'destroy'])->name('admin.manuales.destroy')
        ->middleware(\Spatie\Permission\Middleware\PermissionMiddleware::class . ':manuales.delete');
});

// Cuenta (Perfil y Seguridad)
Route::middleware('auth')->group(function () {
    Route::get('/admin/account/profile', [AccountController::class, 'profile'])->name('admin.account.profile');
    Route::post('/admin/account/profile', [AccountController::class, 'updateProfile'])->name('admin.account.profile.update');
    Route::get('/admin/account/security', [AccountController::class, 'security'])->name('admin.account.security');
    Route::post('/admin/account/security', [AccountController::class, 'updatePassword'])->name('admin.account.security.update');
});