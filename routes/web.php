<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DonorController as DashboardDonorController;
use App\Http\Controllers\Dashboard\AnnouncementController as DashboardAnnouncementController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DonorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [DonorController::class, 'index'])->name('donor')->middleware('auth');
Route::get('/category1', [DonorController::class, 'category1'])->name('category1');
Route::get('/category2', [DonorController::class, 'category2'])->name('category2');
Route::get('/announcement', [AnnouncementController::class, 'index'])->name('announcement');

Route::group([
    'middleware' => ['auth', function ($request, $next) {
        if (Auth::user()->role->name !== 'admin') { // Asumsikan role_id 1 adalah admin
            return redirect()->route('donor')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return $next($request);
    }]
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    //Announcement
    Route::get('announcements', [DashboardAnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('announcements', [DashboardAnnouncementController::class, 'store'])->name('announcements.store');
    Route::put('announcements/{announcement}', [DashboardAnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('announcements/{announcement}', [DashboardAnnouncementController::class, 'destroy'])->name('announcements.destroy');
    //Donor
    Route::get('donors', [DashboardDonorController::class, 'index'])->name('donors.index');
    Route::post('donors', [DashboardDonorController::class, 'store'])->name('donors.store');
    Route::put('donors/{donor}', [DashboardDonorController::class, 'update'])->name('donors.update');
    Route::delete('donors/{donor}', [DashboardDonorController::class, 'destroy'])->name('donors.destroy');
    Route::get('donors/category1', [DashboardDonorController::class, 'category1'])->name('donors.category1');
    Route::get('donors/category2', [DashboardDonorController::class, 'category2'])->name('donors.category2');
});
Route::get('/getCities/{province_id}', [DonorController::class, 'getCities']);
Route::get('/getDistricts/{city_id}', [DonorController::class, 'getDistricts']);
Route::get('/getVillages/{district_id}', [DonorController::class, 'getVillages']);
Route::post('/donor', [DonorController::class, 'store'])->name('donor.store')->middleware('auth');
Route::put('/donor/{donor}/status', [DonorController::class, 'updateStatus'])->name('donor.update.status');
Route::get('/donor/{donor}/detail', [DonorController::class, 'detail'])->name('donor.detail');
Route::post('/donor/{donor}/detail', [DonorController::class, 'detailStore'])->name('donor.detail.store');
Route::patch('/donor-detail/{donorDetail}/update-status', [DonorController::class, 'updateDetailStatus'])->name('donor.detail.update-status');

require __DIR__.'/auth.php';
