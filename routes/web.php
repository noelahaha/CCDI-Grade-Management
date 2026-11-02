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

Route::patch('/requests/{id}/seen', [RequestController::class, 'seen'])
    ->name('requests.seen');

Route::patch('/requests/{id}/printed', [RequestController::class, 'printed'])
    ->name('requests.printed');



//Combined Login    
    Route::get('/login', function () {
    return view('welcome');
})->name('login');