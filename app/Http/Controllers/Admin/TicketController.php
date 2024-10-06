<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\RequesterType;
use App\Models\Source;
use App\Models\Team;
use App\Models\TeamCategory;
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
     * Define public property $requester_type;
     * @var array|object
     */
    public $requester_type;

    /**
     * Define public property $sources;
     * @var array|object
     */
    public $sources;

    /**
     * Define public property $categories;
     * @var array|object
     */
    public $categories;

    /**
     * Define public property $teams;
     * @var array|object
     */
    public $teams;

    /**
     * Define public property $ticket_status;
     * @var array|object
     */
    public $ticket_status;

    /**
     * Define public property $agents;
     * @var array|object
     */
    public $teamAgent;

    /**
     * Define public property $ticket
     */
    public $ticket;

    /**
     * Define public property $tickets
     * @var array|object
     */
    public array | object $tickets = [];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view', Ticket::class);
        //$this->tickets = TicketStatus::query()->with('ticket', fn($query) => $query->with('source', 'ticket_status'))->withCount('ticket')->get();

        $user = User::find(Auth::id());

        $tickets = TicketStatus::query()
            ->with('ticket', function ($query) {
                $query->with(['owners', 'source', 'user', 'team', 'requester_type']);
            })
            ->withCount('ticket')
            ->orderByRaw("CASE WHEN ticket_statuses.name = 'open' THEN 1 ELSE 2 END") // Order by status
            ->orderBy('ticket_statuses.name');

        if ($user->hasRole('super-admin') === false) {
            $tickets->where('towner.owner_id', Auth::id());
        }
        $this->tickets = $tickets->get();

        // return $this->tickets;

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
        $this->requester_type = RequesterType::query()->get();
        $this->sources = Source::query()->get();
        $this->teams = Team::query()->get();
        $this->categories = Category::query()->get();
        $this->ticket_status = TicketStatus::query()->get();
        $this->teamAgent = Team::query()->with('agents')->where('id', $this->ticket?->team_id)->get();
        return view('ticket.show', [
            'ticket' => $ticket,
            'requester_type' => $this->requester_type,
            'sources' => $this->sources,
            'teams' => $this->teams,
            'categories' => $this->categories,
            'ticket_status' => $this->ticket_status,
            'teamAgent' => $this->teamAgent,
        ]);
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
