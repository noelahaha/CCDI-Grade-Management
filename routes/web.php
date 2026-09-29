<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/grade-request', [RequestController::class, 'store'])
    ->name('grade-request.store');


// Route::post('/digital-request', [RequestController::class, 'digitalStore'])
//     ->name('digital-request.store');