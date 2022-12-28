<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function(){

    Route::get('/checkingAuthenticated', function(){
        return response()->json([
             'message' => 'You are in',
            'status' => 200], 200);
    });

    Route::get('view-category', [CategoryController::class, 'index']);

    
    // Catégories

    Route::post('store-category', [CategoryController::class, 'store']);   // Créer un catégorie
    Route::get('edit-category/{id}', [CategoryController::class, 'edit']); // Modifier le catégorie
    Route::get('name-category/{id}', [CategoryController::class, 'nameCategory']); // Nom du catégorie
    Route::put('update-category/{id}', [CategoryController::class, 'update']); // Modifier le catégorie
    Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']); // Supprimer une catégorie

    // Produit
    Route::get('all-category', [CategoryController::class, 'allcategory']); // Récupérer tous les catégories ayant status = 0
    Route::get('list-product', [ProductController::class, 'index']);   // Liste des produits
    Route::get('see-product/{id}', [ProductController::class, 'show']);   // Voir un produits
    Route::post('store-product', [ProductController::class, 'store']);   // Créer un product
});

Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('logout', [AuthController::class, 'logout']);

});

