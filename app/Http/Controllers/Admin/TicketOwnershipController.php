<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketOwnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class TicketOwnershipController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('viewAny', TicketOwnership::class);
        return view("ticketOwnership.index");
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable() {
        Gate::authorize('viewAny', TicketOwnership::class);

        $ticketOwnership = Cache::remember('ticketOwnership_list', 60 * 60, function () {
            return TicketOwnership::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        Gate::authorize('create', TicketOwnership::class);
        return view('ticketOwnership.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
        Gate::authorize('create', TicketOwnership::class);

    }

    /**
     * Display the specified resource.
     */
    public function show(TicketOwnership $ticketOwnership) {
        //
        Gate::authorize('view', $ticketOwnership);
        return view('ticketOwnership.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketOwnership $ticketOwnership) {
        Gate::authorize('update', $ticketOwnership);
        return view('ticketOwnership.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketOwnership $ticketOwnership) {
        Gate::authorize('update', $ticketOwnership);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketOwnership $ticketOwnership) {
        Gate::authorize('delete', $ticketOwnership);
    }
}
