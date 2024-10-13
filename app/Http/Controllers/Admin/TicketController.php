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
use App\Models\TicketOwnership;
use App\Models\TicketStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller {
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
    public function index() {
        Gate::authorize('viewAny', Ticket::class);
        //$this->tickets = TicketStatus::query()->with('ticket', fn($query) => $query->with('source', 'ticket_status'))->withCount('ticket')->get();

        $user     = User::with('teams:id')->find(Auth::id());
        $userTeam = $user->teams->pluck('id');

        $unassignRequest = Cache::remember('unassign_' . Auth::id() . '_ticket_list', 60 * 60, function () use ($userTeam) {
            $unassign = Ticket::query()
                ->leftJoin('ticket_ownerships as towner', 'tickets.id', '=', 'towner.ticket_id')
                ->with(['source', 'user', 'team', 'ticket_status'])
                ->where('towner.owner_id', null)
                ->select('tickets.*', 'towner.owner_id');
            if (!Auth::user()->hasRole('super-admin')) {
                $unassign->whereIn('team_id', $userTeam)
                    ->orWhere('tickets.created_by', Auth::id());
            }

            return $unassign->orderBy('id', 'desc')->take(10)->get();
        });

        $this->tickets = Cache::remember('status_' . Auth::id() . '_ticket_list', 60 * 60, function () {
            return TicketStatus::query()
                ->with('ticket', function ($query) {
                    if (!Auth::user()->hasRole('super-admin')) {
                        $query->whereHas('owners', function ($query) {
                            $query->where('owner_id', Auth::id());
                        });
                    }
                    $query->with(['owners', 'source', 'user', 'team'])
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

        $ticket = Cache::remember('ticket_' . Auth::id() . '_list', 60 * 60, function () {
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
    public function show(Request $request, Ticket $ticket) {
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
        $users                = User::whereNotIn('id', [1])->select('id', 'name', 'email')->get();

        // Get all ticket list according to ticket status
        // $ticketStatusWise = Ticket::where('ticket_status_id', $ticket->ticket_status_id)->get();
        $ticketStatusWiseList = Ticket::query()
            ->where('ticket_status_id', $ticket->ticket_status_id)
            ->whereNot('id', $ticket->id)
            ->whereNotNull('team_id')
            ->orderBy('id', 'desc');
        if (!Auth::user()->hasRole('super-admin')) {
            $ticketStatusWiseList->whereHas('owners', function ($query) {
                $query->where('owner_id', Auth::id());
            });
        }
        $ticketStatusWise = $ticketStatusWiseList->take(5)->get();

        return view('ticket.show', [
            'ticket'           => $ticket,
            'requester_type'   => $this->requester_type,
            'sources'          => $this->sources,
            'teams'            => $this->teams,
            'categories'       => $this->categories,
            'ticket_status'    => $this->ticket_status,
            'agents'           => $agents,
            'ticketStatusWise' => $ticketStatusWise,
            'users'            => $users,
        ]);
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
        $queryStatus = request()->get('ticket_status');
        return view('ticket.view-all', compact('queryStatus'));
    }

    public function allListDataTable(Request $request) {
        Gate::authorize('viewAny', Ticket::class);

        $user     = User::with('teams:id')->find(Auth::id());
        $userTeam = $user->teams->pluck('id');

        $ticketStatus = null;

        if ($request->query_status != 'unassign') {

            $ticketStatus = TicketStatus::where('slug', $request->query_status)->first();
        }

        $tickets = Ticket::query();

        if ($request->query_status == 'unassign') {

            // $tickets = Cache::remember('unassign_' . Auth::id() . '_ticket_list', 60 * 60, function () use ($tickets, $userTeam) {
            $tickets->leftJoin('ticket_ownerships as towner', 'tickets.id', '=', 'towner.ticket_id')
                ->with(['source', 'user', 'team', 'ticket_status'])
                ->where('towner.owner_id', null)
                ->select('tickets.*', 'towner.owner_id');
            if (!Auth::user()->hasRole('super-admin')) {
                $tickets->whereIn('team_id', $userTeam)
                    ->orWhere('tickets.created_by', Auth::id());
            }

            // $tickets->orderBy('id', 'desc');
            // return $tickets->get();
            // });

        } elseif ($ticketStatus->count() > 0 && $ticketStatus->slug == $request->query_status) {

            // $tickets = Cache::remember('ticket_' . Auth::id() . '_list', 60 * 60, function () use ($tickets, $ticketStatus) {
            $tickets->where('ticket_status_id', $ticketStatus->id)
                ->with(['owners', 'source', 'user', 'team'])
                ->whereHas('owners')
                ->whereNotNull('team_id')
                ->orderBy('id', 'desc');
            if (!Auth::user()->hasRole('super-admin')) {
                $tickets->whereHas('owners', function ($query) {
                    $query->where('owner_id', Auth::id());
                });
            }
            // return $tickets->get();
            // });
        }

        return DataTables::of($tickets)
            ->editColumn('priority', function ($tickets) {
                return Str::ucfirst($tickets->priority);
            })
            ->editColumn('status', function ($tickets) {
                $data = "";
                if ($tickets->ticket_status->name === 'in progress') {
                    $data .= '<span class="!bg-process-400 text-white rounded px-3 py-1 font-inter text-sm block">' . $tickets->ticket_status->name . '</span>';
                } elseif ($tickets->ticket_status->name === 'open') {

                    $data .= '<span class="!bg-green-400 text-white rounded px-3 py-1 font-inter text-sm">' . $tickets->ticket_status->name . '</span>';
                } elseif ($tickets->ticket_status->name === 'on hold') {
                    $data .= '<span class="!bg-orange-400 text-white rounded px-3 py-1 font-inter text-sm">' . $tickets->ticket_status->name . '</span>';
                } else {
                    $data .= '<span class="!bg-gray-400 text-white rounded px-3 py-1 font-inter text-sm">' . $tickets->ticket_status->name . '</span>';
                }
                return $data;
            })
            ->editColumn('user_id', function ($tickets) {
                $data = '<div class="p-2 font-normal text-gray-400 flex items-center"><img src="https://i.pravatar.cc/300/5" alt="img" width="40" height="40"
                                style="border-radius: 50%"><span class="ml-2">' . $tickets->user->name . '</span></div>';
                return $data;
            })
            ->editColumn('team_id', function ($tickets) {
                $data = '<span class="font-normal text-gray-400">' . @$tickets->team->name . '</span>';
                return $data;
            })
            ->addColumn('agent', function ($tickets) {
                $data = '<span class="font-normal text-gray-400">' . @$tickets->owners->last()->name . '</span>';
                return $data;
            })
            ->editColumn('created_at', function ($tickets) {
                $data = '<span class="font-normal text-gray-400">' . ISODate($tickets?->created_at) . '</span>';
                return $data;
            })
            ->addColumn('request_age', function ($tickets) {
                $data = '<span class="font-normal text-gray-400">' . dayMonthYearHourMininteSecond($tickets?->created_at, true, true, true) . '</span>';
                return $data;
            })
            ->editColumn('due_date', function ($tickets) {
                $data = '<span class="font-normal text-gray-400">' . ISOdate($tickets->due_date) . '</span>';
                return $data;
            })

            ->addColumn('action_column', function ($tickets) {
                $links = '<div class="relative"><button onclick="toggleAction(' . $tickets->id . ')"
                            class="p-3 hover:bg-slate-100 rounded-full">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.9922 12H12.0012" stroke="#666666" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.9844 18H11.9934" stroke="#666666" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 6H12.009" stroke="#666666" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div id="action-' . $tickets->id . '" class="shadow-lg z-30 absolute top-5 right-10"
                            style="display: none">
                            <ul>
                                <li class="px-5 py-1 text-center" style="background: #FFF4EC;color:#F36D00">
                                    <a
                                        href="' . route('admin.ticket.edit', ['ticket' => $tickets?->id]) . '">Edit</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-white">
                                    <a
                                        href="' . route('admin.ticket.show', ['ticket' => $tickets?->id]) . '">View</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-red-600 text-white">
                                    <a href="#">Delete</a>
                                </li>
                            </ul>
                        </div></div>';

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
    public function logUpdate(Request $request, Ticket $ticket) {

        $request->validate([
            "team_id"          => 'required',
            "category_id"      => 'required',
            "ticket_status_id" => 'required',
            "priority"         => 'required',
            "comment"          => 'required',
        ]);
        DB::beginTransaction();
        try {
            $ticket_status = TicketStatus::query()->where('id', $ticket->ticket_status_id)->first();

            if ($request->owner_id && ($ticket->owners->isEmpty() || $ticket->owners->last()->id != $request->owner_id)) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'owner_change',
                        'note'       => $request->comment,
                        'created_by' => Auth::id(),
                    ]
                );

                $last_owner = TicketOwnership::where('ticket_id', $ticket->id)->where('duration', null)->orderBy('id', 'desc')->first();
                if ($last_owner && $request->owner_id) {
                    $now                 = Carbon::now();
                    $duration_in_seconds = $last_owner->created_at->diffInSeconds($now);
                    $last_owner->update([
                        'duration' => $duration_in_seconds,
                    ]);
                }

                $ticket_agents = $ticket->owners()->attach($request->owner_id);
            }
            if ($ticket->team_id != $request->team_id) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'team_change',
                        'note'       => $request->comment,
                        'created_by' => Auth::id(),
                    ]
                );
            }
            if ($ticket->category_id != $request->category_id) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'category_change',
                        'note'       => $request->comment,
                        'created_by' => Auth::id(),
                    ]
                );
            }
            if ($ticket->priority != $request->priority) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'priority_change',
                        'note'       => $request->comment,
                        'created_by' => Auth::id(),
                    ]
                );
            }

            $old_due_date = $ticket->due_date ? $ticket->due_date->format('Y-m-d') : '';
            if (empty($old_due_date) || $old_due_date != $request->due_date) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'due_date_change',
                        'note'       => $request->comment,
                        'created_by' => Auth::id(),
                    ]
                );
            }
            if ($ticket->ticket_status_id != $request->ticket_status_id) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'status_change',
                        'note'       => $request->comment,
                        'old_status' => $ticket->ticket_status->name,
                        'new_status' => $ticket_status->name,
                        'created_by' => Auth::id(),
                    ]
                );
            }

            $ticket->update(
                [
                    'priority'         => $request->priority,
                    'due_date'         => $request->due_date,
                    'team_id'          => $request->team_id,
                    'category_id'      => $request->category_id,
                    'ticket_status_id' => $request->ticket_status_id,
                    'updated_by'       => Auth::id(),
                ]
            );
            TicketLog::create(
                [
                    'ticket_id'     => $ticket->getKey(),
                    'ticket_status' => $ticket_status->name,
                    'status'        => 'updated',
                    'comment'       => json_encode($ticket),
                    'updated_by'    => Auth::id(),
                    'created_by'    => Auth::id(),
                ]
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            TicketLog::create(
                [
                    'ticket_id'     => $ticket->getKey(),
                    'ticket_status' => $ticket_status->name,
                    'status'        => 'update_fail',
                    'comment'       => json_encode($e->getMessage()),
                    'updated_by'    => Auth::id(),
                    'created_by'    => Auth::id(),
                ]
            );
        }

        flash()->success('Data has been updated successfully');
        return back();
    }
}
