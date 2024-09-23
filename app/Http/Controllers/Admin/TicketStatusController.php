<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class TicketStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view',  TicketStatus::class);
        return view("ticketStatus.index");
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable()
    {
        Gate::authorize('view',  TicketStatus::class);
        
        $ticketStatus = Cache::remember('ticketStatus_list', 60 * 60, function () {
            return TicketStatus::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', TicketStatus::class);
        return view('ticketStatus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Gate::authorize('create', TicketStatus::class);

    }

    /**
     * Display the specified resource.
     */
    public function show(TicketStatus $ticketStatus)
    {
        //
        Gate::authorize('view',  $ticketStatus);
        return view('ticketStatus.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketStatus $ticketStatus)
    {
        Gate::authorize('update', $ticketStatus);
        return view('ticketStatus.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketStatus $ticketStatus)
    {
        Gate::authorize('update',  $ticketStatus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketStatus $ticketStatus)
    {
        Gate::authorize('delete',  $ticketStatus);
    }
}
