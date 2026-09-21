<?php

use App\Http\Controllers\GradeController;
use Illuminate\Support\Facades\Route;

Route::post('/grade-upload', [GradeController::class, 'store'])
    ->name('grade-upload.store');
