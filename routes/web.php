<?php

use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {

    $uers = User::with('roles')->where('id', Auth::id())->first();
    // return $uers;

    return view('dashboard');
})->middleware(['auth', 'verified', 'locale'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/sajal.php';
require __DIR__ . '/thealamdev.php';

Route::get('locale/{lang}', [LocalizationController::class, 'locale'])->name('local');