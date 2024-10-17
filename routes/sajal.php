<?php

// module

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RequesterTypeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TicketOwnershipController;
use App\Http\Controllers\Admin\TicketStatusController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('dashboard')->name('admin.')->group(function () {
    Route::resource('module', ModuleController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('ticket', TicketController::class);
    Route::post('ticket-log-update/{ticket}', [TicketController::class, 'logUpdate'])->name('ticket.logUpdate');
    Route::post('ticket-internal-note-update/{ticket}', [TicketController::class, 'interNoteStore'])->name('ticket.interNoteStore');
    Route::get('ticket-download/{file}', [TicketController::class, 'downloadFile'])->name('ticket.downloadFile');
    Route::post('conversations/{ticket}', [TicketController::class, 'conversation'])->name('ticket.conversation');
    Route::post('ticket-owner-change/{ticket}', [TicketController::class, 'ownerChange'])->name('ticket.ownerChange');
    Route::post('ticket-partial-update/{ticket}', [TicketController::class, 'partialUpdate'])->name('ticket.partialUpdate');
    Route::get('status-wise-ticket-list', [TicketController::class, 'ticketList'])->name('ticket.status.wise.list');
    Route::get('status-wise-ticket-list-datatable', [TicketController::class, 'allListDataTable'])->name('ticket.status.wise.list.datatable');
    Route::resource('category', CategoryController::class);
    Route::resource('team', TeamController::class);
    Route::resource('source', SourceController::class);
    Route::resource('requestertype', RequesterTypeController::class);
    Route::resource('ticketownership', TicketOwnershipController::class);
    Route::resource('ticketstatus', TicketStatusController::class);

    Route::resource('ticket', TicketController::class);
    Route::get('ticket-list', [TicketController::class, 'allTicketList'])->name('all.ticket.list');
    Route::get('ticket-active-memode', [TicketController::class, 'allTicketList'])->name('ticket.list.active.memode');
    Route::get('ticket-list-datatable', [TicketController::class, 'allTicketListDataTable'])->name('all.ticket.list.datatable');
    Route::post('ticket-log-update/{ticket}', [TicketController::class, 'logUpdate'])->name('ticket.logUpdate');
    Route::post('ticket-internal-note-update/{ticket}', [TicketController::class, 'interNoteStore'])->name('ticket.interNoteStore');
    Route::get('ticket-download/{file}', [TicketController::class, 'downloadFile'])->name('ticket.downloadFile');
    Route::post('conversations/{ticket}', [TicketController::class, 'conversation'])->name('ticket.conversation');
    Route::get('status-wise-ticket-list', [TicketController::class, 'ticketList'])->name('ticket.status.wise.list');
    Route::get('status-wise-ticket-list-datatable', [TicketController::class, 'allListDataTable'])->name('ticket.status.wise.list.datatable');

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
