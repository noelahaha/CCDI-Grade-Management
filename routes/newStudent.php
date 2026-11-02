<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

Route::post('/new-student', [StudentController::class, 'store'])
    ->name('new-student.store');

Route::post('/students/upload', [StudentController::class, 'upload'])
    ->name('students.upload');



//Admin Requests



Route::patch('/requests/{id}/availability',
    [RequestController::class, 'updateAvailability']
)->name('requests.availability');

Route::patch('/requests/{id}/received',
    [RequestController::class, 'updateReceived']
)->name('requests.received');

Route::patch('/requests/mark-all-seen',
    [RequestController::class, 'markAllSeen']
)->name('requests.mark-all-seen');