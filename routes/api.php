<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavouriteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| All routes here are prefixed with /api automatically.
*/

// ==================== Public Auth Routes ====================
Route::post('auth/register', [UserController::class, 'register']);
Route::post('auth/login', [UserController::class, 'login']);

// ==================== Protected Auth Routes ====================
Route::middleware(['auth:api', 'check.banned'])->group(function () {
    Route::get('auth/me', [UserController::class, 'me']);
    Route::post('auth/refresh', [UserController::class, 'refresh']);
    Route::post('auth/logout', [UserController::class, 'logout']);
    Route::put('auth/profile', [UserController::class, 'update']);

    // Favourites
    Route::get('favourites', [FavouriteController::class, 'index']);
    Route::post('campaigns/{campaign}/favourite', [FavouriteController::class, 'toggle']);
});

// ==================== Public Routes ====================
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

// ==================== Admin Routes ====================
Route::middleware(['auth:api', 'check.banned', 'admin'])->group(function () {
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    
    // User Management
    Route::post('users/{user}/ban', [UserController::class, 'ban']);
    Route::post('users/{user}/unban', [UserController::class, 'unban']);
});

// ==================== Porter Routes ====================
Route::middleware(['auth:api', 'check.banned', 'porter'])->group(function(){
    Route::get('campaigns', [CampaignController::class, 'index']);
    Route::post('campaigns', [CampaignController::class, 'store']);
    Route::get('campaigns/{id}', [CampaignController::class, 'show']);
    Route::put('campaigns/{id}', [CampaignController::class, 'update']);
    Route::delete('campaigns/{id}', [CampaignController::class, 'destroy']);
    Route::get('campaigns/search', [CampaignController::class, 'search']);
    Route::get('campaigns/filter', [CampaignController::class, 'filter']);
});
