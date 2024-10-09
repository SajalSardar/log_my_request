<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\RequesterType;
use App\Models\Source;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\TicketNote;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

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
        Gate::authorize('viewAny', Ticket::class);
        //$this->tickets = TicketStatus::query()->with('ticket', fn($query) => $query->with('source', 'ticket_status'))->withCount('ticket')->get();

        $user     = User::with('teams:id')->find(Auth::id());
        $userTeam = $user->teams->pluck('id');

        $unassignRequest = Cache::remember('unassign_' . Auth::id() . '_ticket_list', 60 * 60, function () use ($userTeam) {
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

        $this->tickets = Cache::remember('status_' . Auth::id() . '_ticket_list', 60 * 60, function () {
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
    public function displayListDatatable()
    {
        Gate::authorize('viewAny', Ticket::class);

        $ticket = Cache::remember('ticket_' . Auth::id() . '_list', 60 * 60, function () {
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
    public function show(Request $request, Ticket $ticket)
    {
        if ($request->ajax()) {
            $agents = Team::query()->with('agents')->where('id', $request->team_id)->get();
            return response()->json($agents);
        }
        Gate::authorize('view', $ticket);
        $this->requester_type = RequesterType::query()->get();
        $this->sources        = Source::query()->get();
        $this->teams          = Team::query()->get();
        $this->categories     = Category::query()->get();
        $this->ticket_status  = TicketStatus::query()->get();
        $agents               = Team::query()->with('agents')->where('id', $ticket?->team_id)->get();
        // dd($ticket->ticket_status->name);
        return view('ticket.show', [
            'ticket'         => $ticket,
            'requester_type' => $this->requester_type,
            'sources'        => $this->sources,
            'teams'          => $this->teams,
            'categories'     => $this->categories,
            'ticket_status'  => $this->ticket_status,
            'agents'         => $agents,
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

    public function ticketList()
    {
        Gate::authorize('viewAny', Ticket::class);
        $queryStatus = request()->get('ticket_status');
        return view('ticket.view-all', compact('queryStatus'));
    }

    public function allListDataTable(Request $request)
    {
        Gate::authorize('viewAny', Ticket::class);
        $user     = User::with('teams:id')->find(Auth::id());
        $userTeam = $user->teams->pluck('id');

        $ticketStatus = null;

        if ($request->query_status != 'unassign') {

            $ticketStatus = TicketStatus::where('slug', $request->query_status)->first();
        }

        $tickets = Ticket::query();

        if ($request->query_status == 'unassign') {

            $tickets = Cache::remember('unassign_' . Auth::id() . '_ticket_list', 60 * 60, function () use ($tickets, $userTeam) {
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
        } elseif ($ticketStatus->count() > 0 && $ticketStatus->slug == $request->query_status) {

            $tickets = Cache::remember('ticket_' . Auth::id() . '_list', 60 * 60, function () use ($tickets, $ticketStatus) {
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

        return DataTables::of($tickets)

            // ->addColumn('donor', function ($donates) {
            //     return $donates->donar_name ? $donates->donar_name : 'Guest';

            // })
            // ->editColumn('amount', function ($donates) {
            //     return '$' . number_format($donates->amount, 2);
            // })
            // ->editColumn('admin_view', function ($donates) {
            //     return $donates->admin_view == 0 ? 'unread' : 'read';
            // })
            // ->editColumn('created_at', function ($donates) {
            //     return $donates->created_at->format('M d, Y');
            // })
            ->addColumn('action_column', function ($tickets) {
                $links = '';

                //     $links .= '<a href="' . route('dashboard.campaign.donation.admin.donation.show', $tickets->id) . '"
                //     class="btn btn-sm btn-primary" title="View">
                //     View
                // </a>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Define public method logUpdate() to update log of ticket
     * @param Request $request
     */
    public function logUpdate(Request $request, Ticket $ticket)
    {
        $updated_ticket = $ticket->update(
            [
                'source_id'         => $request->source_id,
                'due_date'          => $request->due_date,
                'team_id'           => $request->team_id,
                'category_id'       => $request->category_id,
                'ticket_status_id'  => $request->ticket_status_id,
            ]
        );

        $ticket_status = TicketStatus::query()->where('id', $ticket->ticket_status_id)->first();
        $ticket_agents = $ticket->owners()->attach($request->owner_id);
        $ticket_logs = TicketLog::create(
            [
                'ticket_id'             => $ticket->getKey(),
                'ticket_status'         => $ticket_status->name,
                'status'                => 'updated',
                'comment'               => $ticket,
                'updated_by'            => $request->user()->id,
            ]
        );

        // $ticket_notes = TicketNote::

        flash()->success('Data has been updated successfully');
        return back();
    }
}
