<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MainController::class, 'dasbor'])->name('dasbor');
Route::get('dasbor', [MainController::class, 'dasbor'])->name('dasbor');
Route::post('save_data', [MainController::class, 'save_data'])->name('save_data');
Route::post('show_data', [MainController::class, 'show_data'])->name('show_data');
