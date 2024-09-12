<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TeamController;

Route::middleware(['auth', 'locale'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('user')->name('user.')->group(function () {
            Route::controller(AdminUserController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::get('edit/{user}', 'edit')->name('edit');
                Route::delete('delete/{user}', 'destroy')->name('delete');
            });
        });

        Route::prefix('categories')->name('category.')->group(function () {
            Route::controller(CategoryController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::get('edit/{category}', 'edit')->name('edit');
                Route::delete('delete/{category}', 'destroy')->name('delete');
            });
        });

        Route::prefix('team')->name('team.')->group(function () {
            Route::controller(TeamController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::get('edit/{team}', 'edit')->name('edit');
                Route::delete('delete/{team}', 'destroy')->name('delete');
            });
        });
    });
});
