<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Employee\employeecontroller;
use App\Http\Controllers\Ingresoempleados\ingresoempleadocontroller;
use App\Http\Controllers\Historico\HistoricoController;
use App\Http\Controllers\Reporteingresosdiarios\Reporteingresosdiarios;
use App\Http\Controllers\Reportexempleado\Reportexempleado;


// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

// Resources
Route::resource('Empleado', employeecontroller::class)->names([
    'index' => 'Empleado.index',
    'create' => 'Empleado.create',
    'store' => 'Empleado.store',
    'show' => 'Empleado.show',
    'edit' => 'Empleado.edit',
    'update' => 'Empleado.update',
    'destroy' => 'Empleado.destroy',
]);


Route::resource('IngresoEmpleado', ingresoempleadocontroller::class)->names([
    'index' => 'IngresoEmpleado.index',
    'create' => 'IngresoEmpleado.create',
    'store' => 'IngresoEmpleado.store',
    'show' => 'IngresoEmpleado.show',
    'edit' => 'IngresoEmpleado.edit',
    'update' => 'IngresoEmpleado.update',
    'destroy' => 'IngresoEmpleado.destroy',
]);

Route::resource('Historico', HistoricoController::class)->names([
    'index' => 'Historico.index',
    'create' => 'Historico.create',
    'store' => 'Historico.store',
    'show' => 'Historico.show',
    'edit' => 'Historico.edit',
    'update' => 'Historico.update',
    'destroy' => 'Historico.destroy',
]);

Route::resource('ReporteIngresosDiarios', Reporteingresosdiarios::class)->names([
    'index' => 'ReporteIngresosDiarios.index',
    'create' => 'ReporteIngresosDiarios.create',
    'store' => 'ReporteIngresosDiarios.store',
    'show' => 'ReporteIngresosDiarios.show',
    'edit' => 'ReporteIngresosDiarios.edit',
    'update' => 'ReporteIngresosDiarios.update',
    'destroy' => 'ReporteIngresosDiarios.destroy',
]);

Route::resource('ReporteIngresosxEmpleado', Reportexempleado::class)->names([
    'index' => 'ReporteIngresosxEmpleado.index',
    'create' => 'ReporteIngresosxEmpleado.create',
    'store' => 'ReporteIngresosxEmpleado.store',
    'show' => 'ReporteIngresosxEmpleado.show',
    'edit' => 'ReporteIngresosxEmpleado.edit',
    'update' => 'ReporteIngresosxEmpleado.update',
    'destroy' => 'ReporteIngresosxEmpleado.destroy',
]);