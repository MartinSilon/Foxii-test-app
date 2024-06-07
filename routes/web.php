<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\PartsController;


Route::view('/','home')->name('home');


Route::resource('cars', CarsController::class)->only([
    'index', 'store', 'edit', 'update', 'destroy'
]);
Route::resource('parts', PartsController::class)->only([
    'index', 'store', 'edit', 'update', 'destroy'
]);


// ---- REMOVE PART FROM SPECIFIC CAR ----
Route::put('parts/{part}/remove', [PartsController::class, 'removeFromVehicle'])->name('parts.removeFromVehicle');


