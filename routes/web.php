<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UnitController;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/item', [ItemController::class, 'index'])->name('item');

Route::get('/item/unit', [UnitController::class, 'index'])->name('item-unit');

Route::get('/item/brand', [BrandController::class, 'index'])->name('item-brand');

Route::get('/item/category', [ItemCategoryController::class, 'index'])->name('item-category');