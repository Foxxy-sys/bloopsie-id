<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ShopController;

// 1. BUKA WEB LANGSUNG LEMPAR KE LOGIN
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. HALAMAN CUSTOMER (Diarahkan ke sini setelah login)
Route::get('/home', function () {
    return view('pages.home');
})->name('home');

// 3 HALAMAN SHOP
Route::get('/shop', [ShopController::class, 'index'])->name('shop');

// HALAMAN ABOUT
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/collections', function () {
    return view('pages.collections');
})->name('collections');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');


// 3. HALAMAN KHUSUS ADMIN (Dikawal Middleware 'admin')
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');


// 4. RUTE PROFILE & AUTH BAWAAN BREEZE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

require __DIR__.'/auth.php';