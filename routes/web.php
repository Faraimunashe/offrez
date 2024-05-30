<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Landlord\DashboardController as LandlordDashboardController;
use App\Http\Controllers\Landlord\HouseController;
use App\Http\Controllers\Landlord\RoomController;
use App\Http\Controllers\Landlord\TransactionController as LandlordTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\BookingController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [AuthenticationController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'role:admin']], function(){
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin-dashboard');

});

Route::group(['middleware' => ['auth', 'role:landlord']], function(){
    Route::get('/landlord/dashboard', [LandlordDashboardController::class, 'index'])->name('landlord-dashboard');

    Route::resource('houses', HouseController::class);
    Route::resource('rooms', RoomController::class);
    Route::get('/landlord/transactions', [LandlordTransactionController::class, 'index'])->name('landlord-transactions');
});

Route::group(['middleware' => ['auth', 'role:student']], function(){
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student-dashboard');
    Route::get('/student/house/{id}', [StudentDashboardController::class, 'show'])->name('student-house');

    Route::resource('bookings', BookingController::class);
    Route::resource('transactions', TransactionController::class);
});

require __DIR__.'/auth.php';
