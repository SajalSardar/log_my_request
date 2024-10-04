<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    /**
     * Define public property $tickets
     * @var array|object
     */
    public array|object $tickets = [];

    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('view', Ticket::class);
        //$this->tickets = TicketStatus::query()->with('ticket', fn($query) => $query->with('source', 'ticket_status'))->withCount('ticket')->get();

        $user = User::find(Auth::id());

        $tickets = TicketStatus::query()
            ->join('tickets as t', 'ticket_statuses.id', '=', 't.ticket_status_id')
            ->join('ticket_ownerships as towner', 't.id', '=', 'towner.ticket_id')
            ->with('ticket', function ($query) {
                $query->with(['owners', 'source', 'ticket_status']);
            })
        // ->select('ticket_statuses.*', 't.*', 'towner.*')
            ->select('ticket_statuses.*')
            ->withCount('ticket');

        if ($user->hasRole('super-admin') === false) {
            $tickets->where('towner.owner_id', Auth::id());
        }
        $this->tickets = $tickets->get();

        return view("ticket.index", ['tickets' => $this->tickets ?? collect()]);
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable()
    {
        Gate::authorize('viewAny', Ticket::class);

        $ticket = Cache::remember('ticket_list', 60 * 60, function () {
            return Ticket::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Ticket::class);
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Gate::authorize('create', Ticket::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        Gate::authorize('view', $ticket);
        return view('ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Ticket $ticket
     */
    public function edit(Ticket $ticket)
    {
        Gate::authorize('update', $ticket);
        return view('ticket.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        Gate::authorize('update', $ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        Gate::authorize('delete', $ticket);
    }

    public function viewAll(?string $ticket_status_id)
    {
        $tickets = Ticket::query()->with('ticket_status', 'source', 'requester_type')->where('ticket_status_id', $ticket_status_id)->get();
        return view('ticket.view-all', compact('tickets'));
    }
}
