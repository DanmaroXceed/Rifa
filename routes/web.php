<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'menu'])->name('menu');
Route::get('/rifa', [MainController::class, 'index'])->name('rifa');
Route::get('/premios-disponibles', [MainController::class, 'getPremiosDisponibles']);
Route::get('/empleados-disponibles', [MainController::class, 'getEmpleadosDisponibles']);
Route::post('/registrar-ganador', [MainController::class, 'registrarGanador']);
Route::post('/sorteo-extraoficial', [MainController::class, 'sorteoExtraoficial']);
Route::get('/ganadores', [MainController::class, 'getGanadores']);

Route::post('/resultados', [MainController::class, 'store']);

Route::get('/admin', [MainController::class, 'admin'])->name('admin');
Route::post('/admin/empleados', [MainController::class, 'uploadEmpleados'])->name('admin.upload.empleados');
Route::post('/admin/premios', [MainController::class, 'uploadPremios'])->name('admin.upload.premios');
Route::post('/admin/reset', [MainController::class, 'resetSystem'])->name('admin.reset');
Route::post('/admin/reset/ganadores', [MainController::class, 'resetGanadores'])->name('admin.reset.ganadores');