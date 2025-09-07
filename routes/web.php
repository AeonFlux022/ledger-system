<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

// view home page
Route::get('/', function () {
    return view('welcome');
});


// create user routes
// Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [UserController::class, 'register']);

// login and logout routes
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// client borrowers pages
// display borrowers in client side
Route::get('/borrowers', [BorrowerController::class, 'indexClient'])->name('borrowers.client');

// search for a borrower
Route::get('/borrowers/search', [BorrowerController::class, 'search'])->name('borrowers.search');


// show a single borrower in client side
Route::get('/borrowers/{borrower}', [BorrowerController::class, 'showClient'])->name('showBorrower');

// client loans page
Route::get('/borrowers/{borrower}/loans', [LoanController::class, 'clientLoans'])
    ->name('loans.client');

// show loan amortization schedule
Route::get('/borrowers/{borrower}/loans/{loan}', [LoanController::class, 'showSchedule'])
    ->name('loans.schedule');


// view admin panel
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// user routes
// list all users from the database
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');

// create a new user
Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');

// update user
Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');

// delete user
Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');



// borrower routes

// list all borrowers from the database
Route::get('/admin/borrowers', [BorrowerController::class, 'index'])->name('admin.borrowers.index');

// show a single borrower
Route::get('/admin/borrowers/{borrower}', [BorrowerController::class, 'show'])->name('admin.borrowers.show');

// show create form for a borrower
Route::get('/admin/borrowers/create', [BorrowerController::class, 'create'])->name('admin.borrowers.create');

// store a new borrower
Route::post('/admin/borrowers', [BorrowerController::class, 'store'])->name('admin.borrowers.store');

// update a borrower
Route::put('/admin/borrowers/{borrower}', [BorrowerController::class, 'update'])->name('admin.borrowers.update');

// delete a borrower
Route::delete('/admin/borrowers/{borrower}', [BorrowerController::class, 'destroy'])->name('admin.borrowers.destroy');



// admin side loans
// loan routes
Route::get('/admin/loans', [LoanController::class, 'index'])->name('admin.loans.index');

// store a new loan
Route::post('/admin/loans', [LoanController::class, 'store'])->name('admin.loans.store');

// get one loan 
Route::get('/admin/loans/{loan}', [LoanController::class, 'show'])->name('admin.loans.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('loans', LoanController::class);

    // Custom routes for loan status
    Route::post('/admin/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::post('/admin/loans/{loan}/decline', [LoanController::class, 'decline'])->name('loans.decline');
});


// edit loan
Route::put('/admin/loans/{loan}', [LoanController::class, 'update'])->name('admin.loans.update');



// payment routes
// get all payment transactions


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/payments', [PaymentController::class, 'index'])->name('loans.payments.index');
    Route::post('/loans/{loan}/payments', [PaymentController::class, 'store'])
        ->name('loans.payments.store');
});
