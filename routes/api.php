<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\OrganisationController;

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
    Route::post('auth/avatar', [UserController::class, 'uploadAvatar']);

    // Favourites
    Route::get('favourites', [FavouriteController::class, 'index']);
    Route::post('campaigns/{campaign}/favourite', [FavouriteController::class, 'toggle']);

    // Donations
    Route::post('campaigns/{id}/donate', [DonationController::class, 'donate']);
    Route::get('my-donations', [DonationController::class, 'myDonations']);
});

// ==================== Public Routes ====================
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

// Public campaign routes (read-only)
Route::get('campaigns', [CampaignController::class, 'index']);
Route::get('campaigns/search', [CampaignController::class, 'search']);
Route::get('campaigns/filter', [CampaignController::class, 'filter']);
Route::get('campaigns/{id}', [CampaignController::class, 'show']);

// Organisation public routes
Route::get('organisations', [OrganisationController::class, 'index']);
Route::post('organisations/register', [OrganisationController::class, 'register']);
Route::post('organisations/login', [OrganisationController::class, 'login']);
Route::get('organisations/{id}', [OrganisationController::class, 'show']);

// ==================== Admin Routes ====================
Route::middleware(['auth:api', 'check.banned', 'admin'])->group(function () {
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    // User Management
    Route::get('users', [UserController::class, 'index']);
    Route::post('users/{user}/ban', [UserController::class, 'ban']);
    Route::post('users/{user}/unban', [UserController::class, 'unban']);

    // Organisation Management
    Route::get('organisations/pending', [OrganisationController::class, 'pending']);
    Route::post('organisations/{id}/verify', [OrganisationController::class, 'verify']);
    Route::post('organisations/{id}/reject', [OrganisationController::class, 'reject']);

    // Campaign moderation
    Route::get('campaigns/all', [CampaignController::class, 'all']);
    Route::get('campaigns/pending', [CampaignController::class, 'pending']);
    Route::post('campaigns/{id}/approve', [CampaignController::class, 'approve']);
    Route::post('campaigns/{id}/reject', [CampaignController::class, 'reject']);
});

// ==================== Porter Routes ====================
Route::middleware(['auth:api', 'check.banned', 'porter'])->group(function () {
    Route::post('campaigns', [CampaignController::class, 'store']);
    Route::get('my-campaigns', [CampaignController::class, 'myCampaigns']);
    Route::put('campaigns/{id}', [CampaignController::class, 'update']);
    Route::delete('campaigns/{id}', [CampaignController::class, 'destroy']);
    Route::post('campaigns/{id}/image', [CampaignController::class, 'uploadImage']);
});
