<?php

use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/campaigns', [FrontendController::class, 'campaigns'])->name('campaigns.index');
Route::get('/campaigns/{id}', [FrontendController::class, 'campaigns'])->name('campaigns.show');
Route::get('/organisations', [FrontendController::class, 'organisations'])->name('organisations.index');
Route::get('/profile', [FrontendController::class, 'profile'])->name('profile');
Route::get('/porter/dashboard', [FrontendController::class, 'dashboard'])->name('dashboard');
Route::get('/porter/campaign/create', [FrontendController::class, 'createCampaign'])->name('porter.campaign.create');
Route::get('/admin', [FrontendController::class, 'adminDashboard'])->name('admin.dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [FrontendController::class, 'login'])->name('login');
    Route::get('/register', [FrontendController::class, 'register'])->name('register');
    Route::get('/organisations/login', [FrontendController::class, 'organisationLogin'])->name('organisations.login');
    Route::get('/organisations/register', [FrontendController::class, 'organisationRegister'])->name('organisations.register');
});

Route::post('/logout', [FrontendController::class, 'logout'])->name('logout');


