<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/admin-login', function () {
    return view('admin-login');
})->name('admin-login');

Route::post('/admin-login', [AdminController::class, 'login'])
    ->name('admin.login');