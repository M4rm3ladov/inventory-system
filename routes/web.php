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

//items
Route::group(['prefix' => 'item', 'as' => 'item', 'middleware' => ['auth', 'can:admin']], function() {
    Route::get('', [ItemController::class, 'index'])->name('');
    
    Route::get('/unit', [UnitController::class, 'index'])->name('-unit');
    
    Route::get('/brand', [BrandController::class, 'index'])->name('-brand');
    
    Route::get('/category', [ItemCategoryController::class, 'index'])->name('-category');
});

//services
Route::group(['prefix' => 'service', 'middleware' => ['auth', 'can:admin']], function() {
    Route::get('', [ServiceController::class, 'index'])->name('service');
    
    Route::get('category', [ServiceCategoryController::class, 'index'])->name('service-category');
});

Route::get('/branch', [BranchController::class, 'index'])->name('branch')->middleware(['auth', 'can:admin']);

Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier')->middleware(['auth', 'can:admin']);

//inventories
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory')->middleware(['auth', 'can:admin']);
Route::group(['as' => 'stock-', 'middleware' => ['auth', 'can:manager']], function() {
    Route::get('/stock-in', [StockInController::class, 'index'])->name('in');
    
    Route::get('/stock-return', [StockReturnController::class, 'index'])->name('return');
    
    Route::get('/stock-transfer', [StockTransferController::class, 'index'])->name('transfer');
    
    Route::get('/stock-out', [StockOutController::class, 'index'])->name('out');
    
    Route::get('/stock-count', [StockCountController::class, 'index'])->name('count');
});

