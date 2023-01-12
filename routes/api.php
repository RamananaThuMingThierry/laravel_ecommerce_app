<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UsersController;
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
    Route::put('update-category/{id}', [CategoryController::class, 'update']); // Modifier le catégorie
    Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']); // Supprimer une catégorie

    // Produit
    Route::get('all-category', [CategoryController::class, 'allcategory']); // Récupérer tous les catégories ayant status = 0
    Route::post('store-product', [ProductController::class, 'store']);   // Créer un product
    Route::get('list-product', [ProductController::class, 'index']);   // Liste des produits
    Route::get('retreive-product/{id}', [ProductController::class, 'retreive']);   // Voir un produits
    Route::put('update-product/{id}', [ProductController::class, 'update']);   // Modifier un produits
   
    
    // users
    Route::get('users', [UsersController::class, 'index']);   // Liste des utilisateurs
    Route::get('see-product/{id}', [UsersController::class, 'show']);   // Voir un utilisateur
    Route::put('update-product/{id}', [UsersController::class, 'update']);   // Modifier un utilisateur
    Route::post('store-product', [UsersController::class, 'store']);   // Créer un utilisateur
});

Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('logout', [AuthController::class, 'logout']);

});

