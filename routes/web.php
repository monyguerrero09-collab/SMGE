<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/', function () {
    return view('dashboard.user');
});

Route::get('/employee', function () {
    return view('dashboard.employee');
});

Route::get('/admin', function () {
    return view('dashboard.admin');
});
