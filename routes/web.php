<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'menu'])->name('menu');
Route::get('/rifa', [MainController::class, 'index'])->name('rifa');
Route::post('/resultados', [MainController::class, 'store']);

Route::get('/admin', [MainController::class, 'admin'])->name('admin');
Route::post('/admin/empleados', [MainController::class, 'uploadEmpleados'])->name('admin.upload.empleados');
Route::post('/admin/premios', [MainController::class, 'uploadPremios'])->name('admin.upload.premios');
Route::post('/admin/reset', [MainController::class, 'resetSystem'])->name('admin.reset');