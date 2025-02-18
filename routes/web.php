<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ReportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
Route::get('/ciudades/{departamento_id}', [EmpleadoController::class, 'getCiudades'])->name('empleados.getCiudades');
Route::post('/empleados/store', [EmpleadoController::class, 'store'])->name('empleados.store');
Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
Route::get('/empleados/{id}/edit', [EmpleadoController::class, 'edit'])->name('empleados.edit');
Route::post('/empleados/update', [EmpleadoController::class, 'update'])->name('empleados.update');
Route::get('/empleados/eliminar/{id}', [EmpleadoController::class, 'destroy'])->name('empleados.eliminar');


Route::get('generar-informe-empleados', [ReportController::class, 'generarInforme'])->name('generar-informe-empleados');