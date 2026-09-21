<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::post('/new-student', [StudentController::class, 'store'])
    ->name('new-student.store');