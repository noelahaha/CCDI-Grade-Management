<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;

Route::post('/grades/upload', [GradeController::class, 'upload'])
    ->name('grades.upload')
    ->middleware('admin');

Route::post('/grade-upload', [GradeController::class, 'store'])
    ->name('grades.store')
    ->middleware('admin');