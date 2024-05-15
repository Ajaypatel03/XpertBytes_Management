<?php

use App\Http\Controllers\BoardMemberController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\EmployController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EntriesController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes(['register' => true,'login' => true]);

Route::middleware('auth')->group(function () {
    Route::get('/',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'openProfilePage'])->name('profile');
    Route::post('profile',[ProfileController::class , 'storeProfilePage'])->name('profile.store');

    Route::resource('boardMembers', BoardMemberController::class);
    Route::get('boardMembers/{id}/edit', [BoardMemberController::class, 'edit']);

    Route::resource('clients', ClientController::class);
    Route::get('clients/{id}/edit', [ClientController::class, 'edit']);

    Route::resource('employs', EmployController::class);
    Route::get('employs/{id}/edit', [EmployController::class, 'edit']);

    Route::resource('expenses', ExpenseController::class);
    Route::get('expenses/{id}/edit', [ExpenseController::class, 'edit']);

    Route::resource('salaries', SalaryController::class);
    Route::get('salaries/{id}/edit', [SalaryController::class, 'edit']);

    Route::resource('debit', DebitController::class);
    Route::get('debit/{id}/edit', [DebitController::class, 'edit']);

    Route::resource('invest', InvestmentController::class);
    Route::get('invest/{id}/edit', [InvestmentController::class, 'edit']);

    Route::resource('entries', EntriesController::class); 

    Route::resource('report', ReportController::class);  
    Route::get('/report', [ReportController::class , 'index'])->name('report.index');


     // Logout route
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    
});





 