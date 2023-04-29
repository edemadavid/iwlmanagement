<?php

use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\Inventory\InventoryGroupController;
use App\Http\Controllers\Inventory\InventoryTransactionController;
use App\Http\Controllers\RoleController;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dasboard');

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('inventoryGroup', InventoryGroupController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('inventories', InventoryController::class);

    Route::get('inventory/transactions', [InventoryTransactionController::class, 'index'])->name('transactions');
    Route::get('inventory/transactions/all', [InventoryTransactionController::class, 'indexAll'])->name('transactions.all');

    Route::post('inventories/stock/add', [InventoryTransactionController::class, 'incoming'])->name('inventory.stock.add');
    Route::post('inventories/stock/take', [InventoryTransactionController::class, 'outgoing'])->name('inventory.stock.take');

});

