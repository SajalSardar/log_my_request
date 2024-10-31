<?php

// module

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RequesterTypeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TicketStatusController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('dashboard')->name('admin.')->group(function () {
    Route::resource('module', ModuleController::class);
    Route::resource('menu', MenuController::class);
    Route::get('menu-list-datatable', [MenuController::class, 'displayListDatatable'])->name('menu.list.datatable');
    Route::resource('category', CategoryController::class)->except(['store', 'update']);
    Route::resource('team', TeamController::class)->except(['store', 'update']);
    Route::resource('source', SourceController::class)->except(['store', 'update']);
    Route::resource('requestertype', RequesterTypeController::class)->except(['store', 'update']);
    Route::resource('department', DepartmentController::class)->except(['store', 'update']);

    Route::controller(TicketStatusController::class)->name('ticketstatus.')->group(function () {
        Route::get('request-status', 'index')->name('index');
        Route::get('request-status-create', 'create')->name('create');
        Route::get('request-show/{ticketstatus}', 'show')->name('show');
        Route::get('request-edit/{ticketstatus}', 'edit')->name('edit');
        Route::delete('request-delete/{ticketstatus}', 'destroy')->name('delete');
    });

    Route::controller(TicketController::class)->name('ticket.')->group(function () {
        Route::get('requests', 'index')->name('index');
        Route::get('create-request', 'create')->name('create');
        Route::get('show-request/{ticket}', 'show')->name('show');
        Route::get('edit-request/{ticket}', 'edit')->name('edit');
        Route::delete('delete-request/{ticket}', 'destroy')->name('delete');

        Route::get('request-list', 'allTicketList')->name('all.list');
        Route::get('request-active-memode', 'allTicketList')->name('list.active.memode');
        Route::get('request-list-datatable', 'allTicketListDataTable')->name('all.list.datatable');
        Route::post('request-log-update/{ticket}', 'logUpdate')->name('logUpdate');
        Route::post('request-internal-note-update/{ticket}', 'interNoteStore')->name('interNoteStore');
        Route::get('request-download/{file}', 'downloadFile')->name('downloadFile');
        Route::get('status-wise-request-list', 'ticketList')->name('status.wise.list');
        Route::get('status-wise-request-list-datatable', 'allListDataTable')->name('status.wise.list.datatable');
        Route::post('request-owner-change/{ticket}', 'ownerChange')->name('ownerChange');
        Route::post('request-partial-update/{ticket}', 'partialUpdate')->name('partialUpdate');
        Route::get('get-category-wise-subcategory', 'categoryWiseSubcategory')->name('category.wise.subcategory');
        Route::get('get-department-wise-team', 'departmentWiseTeam')->name('department.wise.team');

    });

    // role
    Route::get('role-list', [RoleController::class, 'index'])->name('role.index');
    Route::get('create-user-role', [RoleController::class, 'create'])->name('role.create');
    Route::post('create-user-role', [RoleController::class, 'store'])->name('role.store');
    Route::get('edit-user-role/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('update-user-role/{id}', [RoleController::class, 'update'])->name('role.update');

    //user
    Route::get('get-user-by-id', [AdminUserController::class, 'getUserById'])->name('get.user.by.id');
    // change role in header option
    Route::post('switch-accont', [RoleController::class, 'switchAccount'])->name('role.swotch');
});
