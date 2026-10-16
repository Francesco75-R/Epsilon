<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\insert_users;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/login', function () {
    return view('login_client');
})->name('login');

Route::post('/register-client', [insert_users::class, 'store'])->name('register.store');
