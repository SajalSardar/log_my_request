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

class TicketController extends Controller {
    /**
     * Define public property $tickets
     * @var array|object
     */
    public array | object $tickets = [];

    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::authorize('viewAny', Ticket::class);
        //$this->tickets = TicketStatus::query()->with('ticket', fn($query) => $query->with('source', 'ticket_status'))->withCount('ticket')->get();

        $user     = User::with('teams:id')->find(Auth::id());
        $userTeam = $user->teams->pluck('id');

        $unassignRequest = Cache::remember('unassign_ticket_list', 60 * 60, function () use ($userTeam) {
            $unassign = Ticket::query()
                ->leftJoin('ticket_ownerships as towner', 'tickets.id', '=', 'towner.ticket_id')
                ->with(['source', 'user', 'team', 'requester_type', 'ticket_status'])
                ->where('towner.owner_id', null)
                ->select('tickets.*', 'towner.owner_id');
            if (!Auth::user()->hasRole('super-admin')) {
                $unassign->whereIn('team_id', $userTeam)
                    ->orWhere('tickets.created_by', Auth::id());
            }

            return $unassign->orderBy('id', 'desc')->paginate(10);
        });

        $this->tickets = Cache::remember('status_ticket_list', 60 * 60, function () {
            return TicketStatus::query()
                ->with('ticket', function ($query) {
                    if (!Auth::user()->hasRole('super-admin')) {
                        $query->whereHas('owners', function ($query) {
                            $query->where('owner_id', Auth::id());
                        });
                    }
                    $query->with(['owners', 'source', 'user', 'team', 'requester_type'])
                        ->whereHas('owners')
                        ->whereNotNull('team_id')
                        ->orderBy('id', 'desc')
                        ->take(10);
                })
                ->orderByRaw("CASE WHEN ticket_statuses.name = 'open' THEN 1 ELSE 2 END")
                ->orderBy('ticket_statuses.name')
                ->get();
        });

        // return $this->tickets;

        return view("ticket.index", ['tickets' => $this->tickets ?? collect(), 'unassignTicket' => $unassignRequest]);
    }

    /**
     * Display a listing of the data table resource.
     */
    public function displayListDatatable() {
        Gate::authorize('viewAny', Ticket::class);

        $ticket = Cache::remember('ticket_list', 60 * 60, function () {
            return Ticket::get();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        Gate::authorize('create', Ticket::class);
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
        Gate::authorize('create', Ticket::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket) {
        Gate::authorize('view', $ticket);
        // $ticket = Ticket::where('id', $ticket->id)->with('category')->first();
        // return $ticket;
        return view('ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Ticket $ticket
     */
    public function edit(Ticket $ticket) {
        Gate::authorize('update', $ticket);
        return view('ticket.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket) {
        Gate::authorize('update', $ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket) {
        Gate::authorize('delete', $ticket);
    }

    public function ticketList() {
        Gate::authorize('viewAny', Ticket::class);
        $user        = User::with('teams:id')->find(Auth::id());
        $userTeam    = $user->teams->pluck('id');
        $queryStatus = request()->get('ticket_status');

        $ticketStatus = TicketStatus::where('slug', $queryStatus)->first();

        $tickets = Ticket::query();

        if ($queryStatus == 'unassign') {
            $tickets = Cache::remember('unassign_ticket_list', 60 * 60, function () use ($tickets, $userTeam) {
                $tickets->leftJoin('ticket_ownerships as towner', 'tickets.id', '=', 'towner.ticket_id')
                    ->with(['source', 'user', 'team', 'requester_type', 'ticket_status'])
                    ->where('towner.owner_id', null)
                    ->select('tickets.*', 'towner.owner_id');
                if (!Auth::user()->hasRole('super-admin')) {
                    $tickets->whereIn('team_id', $userTeam)
                        ->orWhere('tickets.created_by', Auth::id());
                }

                $tickets->orderBy('id', 'desc');
                return $tickets->get();
            });

        } elseif ($ticketStatus->slug == $queryStatus) {
            $tickets = Cache::remember('ticket_list', 60 * 60, function () use ($tickets, $ticketStatus) {
                $tickets->where('ticket_status_id', $ticketStatus->id)
                    ->with(['owners', 'source', 'user', 'team', 'requester_type'])
                    ->whereHas('owners')
                    ->whereNotNull('team_id')
                    ->orderBy('id', 'desc');
                if (!Auth::user()->hasRole('super-admin')) {
                    $tickets->whereHas('owners', function ($query) {
                        $query->where('owner_id', Auth::id());
                    });
                }
                return $tickets->get();
            });

        }

        // return $tickets;
        return view('ticket.view-all', compact('tickets'));
    }
}
