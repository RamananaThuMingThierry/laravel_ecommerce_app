<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CartController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('add-to-cart',[CartController::class, 'addtocart']);
Route::post('place-order',[CheckoutController::class, 'commandes']);
Route::get('cart',[CartController::class, 'show']);
Route::delete('delete-cartitem/{cart_id}',[CartController::class, 'destroy']);
Route::put('cart-updatequantity/{cart_id}/{scope}',[CartController::class, 'updatequantity']);



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
    Route::post('update-product/{id}', [ProductController::class, 'update']);   // Modifier un produits
    Route::get('fetchproduct/{slug}', [ProductController::class, 'fetchproduct']);   // Modifier un produits
    Route::get('collections-view-product/{category_slug}/{product_slug}', [ProductController::class, 'productdetails']);   // Collections veiw produits
   
   
    // users
    Route::get('users', [UsersController::class, 'index']);   // Liste des utilisateurs
    // Route::get('see-users/{id}', [UsersController::class, 'show']);   // Voir un utilisateur
    // Route::put('update-users/{id}', [UsersController::class, 'update']);   // Modifier un utilisateur
    // Route::post('store-users', [UsersController::class, 'store']);   // Créer un utilisateur
});

Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('logout', [AuthController::class, 'logout']);

});

