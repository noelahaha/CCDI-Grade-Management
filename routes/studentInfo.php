<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::post('/student-info', [StudentController::class, 'store']);
  
