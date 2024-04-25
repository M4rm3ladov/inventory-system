<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StockCountController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\StockReturnController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
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

Route::get('/service', [ServiceController::class, 'index'])->name('service');

Route::get('/service/category', [ServiceCategoryController::class, 'index'])->name('service-category');

Route::get('/branch', [BranchController::class, 'index'])->name('branch');

Route::post('/branch/create', [BranchController::class, 'store'])->name('branch.create');

Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');

Route::get('/stock-in', [StockInController::class, 'index'])->name('stock-in');

Route::get('/stock-return', [StockReturnController::class, 'index'])->name('stock-return');

Route::get('/stock-transfer', [StockTransferController::class, 'index'])->name('stock-transfer');

Route::get('/stock-out', [StockOutController::class, 'index'])->name('stock-out');

Route::get('/stock-count', [StockCountController::class, 'index'])->name('stock-count');

Route::get('/user', [UserController::class, 'index'])->name('user');
