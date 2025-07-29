<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowerController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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



// view admin panel
Route::get('/dashboard', function () {
    return view('pages.admin.dashboard');
});

// client borrowers page
Route::get('/borrowers-client', function () {
    return view('pages.borrowers-client');
});


// get all users from the database
Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');

// create a new user
Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');

// update user
Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');

// delete user
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');



// borrower routes
Route::post('/borrowers', [BorrowerController::class, 'store']);




// template routes
Route::get('/borrowers', function () {
    return view('pages.admin.borrowers');
});
Route::get('/loans', function () {
    return view('pages.admin.loans');
});
Route::get('/transactions', function () {
    return view('pages.admin.transactions');
});
