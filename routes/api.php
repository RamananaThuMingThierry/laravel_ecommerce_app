<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function(){

    Route::get('/checkingAuthenticated', function(){
        return response()->json([
             'message' => 'You are in',
            'status' => 200], 200);
    });

    

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('store-category', [CategoryController::class, 'store']);
});

Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('logout', [AuthController::class, 'logout']);
    
});

