<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class TicketStatusController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('viewAny', TicketStatus::class);
        $ticketStatuses = Cache::remember('ticketStatus_list', 60 * 60, function () {
            return TicketStatus::get();
        });
        return view("ticketStatus.index", compact('ticketStatuses'));
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable() {
        Gate::authorize('viewAny', TicketStatus::class);

        $ticketStatus = Cache::remember('ticketStatus_list', 60 * 60, function () {
            return TicketStatus::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        Gate::authorize('create', TicketStatus::class);
        return view('ticketStatus.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketStatus $ticketstatus) {
        //
        Gate::authorize('view', $ticketstatus);
        return view('ticketStatus.show', compact('ticketstatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketStatus $ticketstatus) {
        Gate::authorize('update', $ticketstatus);
        return view('ticketStatus.edit', compact('ticketstatus'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketStatus $ticketStatus) {
        Gate::authorize('delete', $ticketStatus);
    }
}
