<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::post('/login-info', [StudentController::class, 'login'])
    ->name('login-info');