<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\IncomeController;
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
    return redirect()->route('login');
});

// Route::get('admin-login', )

Route::group(['middleware' => ['verified', 'auth'], 'prefix' => 'account'], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('clients', ClientController::class);

    Route::resource('admins', AdminController::class);

    Route::resource('budgets', BudgetController::class);

    Route::resource('income-categories', IncomeCategoryController::class);
    Route::resource('expense-categories', ExpenseCategoryController::class);

    Route::resource('incomes', IncomeController::class);
    Route::resource('expenses', ExpenseController::class);

});