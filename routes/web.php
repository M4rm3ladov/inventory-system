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
Route::group(['prefix' => 'items', 'as' => 'items', 'middleware' => ['auth', 'can:admin']], function() {
    Route::get('', [ItemController::class, 'index'])->name('');
    
    Route::get('/units', [UnitController::class, 'index'])->name('.units');
    
    Route::get('/brands', [BrandController::class, 'index'])->name('.brands');
    
    Route::get('/categories', [ItemCategoryController::class, 'index'])->name('.categories');
});

//services
Route::group(['prefix' => 'services', 'middleware' => ['auth', 'can:admin']], function() {
    Route::get('', [ServiceController::class, 'index'])->name('services');
    
    Route::get('categories', [ServiceCategoryController::class, 'index'])->name('services.categories');
});

Route::get('/branches', [BranchController::class, 'index'])->name('branches')->middleware(['auth', 'can:admin']);

Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers')->middleware(['auth', 'can:admin']);

//inventories
Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories')->middleware(['auth', 'can:manager']);
Route::group(['as' => 'stock-', 'middleware' => ['auth', 'can:manager']], function() {
    Route::get('/stock-in', [StockInController::class, 'index'])->name('in');
    
    Route::get('/stock-return', [StockReturnController::class, 'index'])->name('return');
    
    Route::get('/stock-transfer', [StockTransferController::class, 'index'])->name('transfer');
    
    Route::get('/stock-out', [StockOutController::class, 'index'])->name('out');
    
    Route::get('/stock-count', [StockCountController::class, 'index'])->name('count');
});

