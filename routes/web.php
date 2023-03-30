<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class)->except('show');
    Route::prefix('calculations')->name('calcultions.')->group(function () {
        Route::resource('simple-additive-weightings', \App\Http\Controllers\Admin\Calculation\SimpleAdditiveWeightingController::class)->only('index');
        Route::resource('mooras', \App\Http\Controllers\Admin\Calculation\MooraController::class)->only('index');
    });
//    Route::resource('matrix', \App\Http\Controllers\Admin\MatrixController::class)->only('index');
//    Route::resource('normalizations', \App\Http\Controllers\Admin\NormalizationController::class)->only('index');
//    Route::resource('calculations', \App\Http\Controllers\Admin\CalculationController::class)->only('index');
});

Route::redirect('/', \route('admin.employees.index'));
