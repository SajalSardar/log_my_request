<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Bucket;
use App\Http\Controllers\Controller;
use App\LocaleStorage\Fileupload;
use App\Mail\ConversationMail;
use App\Mail\LogUpdateMail;
use App\Mail\TicketEmail;
use App\Mail\UpdateInfoMail;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Department;
use App\Models\Image;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

        $this->tickets = Cache::remember('status_' . Auth::id() . '_ticket_list', 60 * 60, function () {
            return TicketStatus::query()
                ->with('ticket', function ($query) {
                    $query->with(['owners', 'source', 'user', 'team'])
                        ->orderBy('id', 'desc')
                        ->take(10);
                })
                ->orderByRaw("CASE WHEN ticket_statuses.name = 'open' THEN 1 ELSE 2 END")
                ->orderBy('ticket_statuses.name')
                ->get();
        });

        // return $this->tickets;

        return view("ticket.index", ['tickets' => $this->tickets ?? collect()]);
    }

    public function allTicketList() {
        Gate::authorize('viewAny', Ticket::class);
        $categories   = Category::where('status', 1)->get();
        $teams        = Team::where('status', 1)->get();
        $ticketStatus = TicketStatus::where('status', 1)->get();
        return view('ticket.all_list', compact('categories', 'teams', 'ticketStatus'));
    }

    /**
     * Define all ticket list datatable
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allTicketListDataTable(Request $request) {
        Gate::authorize('viewAny', Ticket::class);

        $tickets = Ticket::query()->with(['owners', 'source', 'user', 'team', 'category', 'ticket_status', 'department']);
        if (Auth::user()->hasRole('requester')) {
            $tickets->where('user_id', Auth::id());
        }

        if ($request->all()) {
            $tickets->where(function ($query) use ($request) {
                if ($request->me_mode_search) {
                    $query->whereHas('owners', function ($query) {
                        $query->where('owner_id', Auth::id());
                    });
                }
                if ($request->ticket_id_search) {
                    $query->where('id', 'like', '%' . $request->ticket_id_search . '%')
                        ->orWhere('title', 'like', '%' . $request->ticket_id_search . '%');
                }
                if ($request->priority_search) {
                    $query->where('priority', '=', $request->priority_search);
                }
                if ($request->category_search) {
                    $query->where('category_id', '=', $request->category_search);
                }
                if ($request->team_search) {
                    $query->where('team_id', '=', $request->team_search);
                }
                if ($request->status_search) {
                    $query->where('ticket_status_id', '=', $request->status_search);
                }
                if ($request->due_date_search) {
                    $dueDate = '';

                    switch ($request->due_date_search) {
                    case 'today':
                        $todayDate = Carbon::today()->toDateString();
                        $query->whereDate('due_date', '=', $todayDate);
                        break;

                    case 'tomorrow':
                        $tomorrowDate = Carbon::tomorrow()->toDateString();
                        $query->whereDate('due_date', '=', $tomorrowDate);
                        break;

                    case 'this_week':
                        $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
                        $endOfWeek   = Carbon::now()->endOfWeek()->toDateString();
                        $query->whereBetween('due_date', [$startOfWeek, $endOfWeek]);
                        break;

                    case 'this_month':
                        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
                        $endOfMonth   = Carbon::now()->endOfMonth()->toDateString();
                        $query->whereBetween('due_date', [$startOfMonth, $endOfMonth]);
                        break;

                    default:
                        break;
                    }
                }
            });
        }
        return DataTables::of($tickets)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #ddd; accent-color: !important #5C5C5C;">
                </div>';
            })
            ->editColumn('title', function ($tickets) {
                return '<a href="' . route('admin.ticket.show', ['ticket' => $tickets?->id]) . '" class="pr-4 text-title hover:text-orange-300 hover:underline block w-72">' . Str::limit(ucfirst($tickets->title), 50, '...') . '</a>';
            })
            ->editColumn('priority', function ($tickets) {
                return '<span class="text-title w-20 pr-3 block">' . Str::ucfirst($tickets->priority) . '</span>';
            })
            ->editColumn('department_id', function ($tickets) {
                return '<span class="text-title w-40 block pr-3">' . Str::ucfirst(@$tickets->department->name) . '</span>';
            })
            ->editColumn('category_id', function ($tickets) {
                return '<span class="text-title w-44 block pr-4">' . Str::ucfirst($tickets->category->name) . '</span>';
            })
            ->editColumn('ticket_status_id', function ($tickets) {
                $data = "";
                if ($tickets->ticket_status->name === 'in progress') {
                    $data .= '<span style="display:inline-block;" class="py-2 !bg-process-400 text-white rounded px-3 font-inter text-sm block">' . ucfirst($tickets->ticket_status->name) . '</span>';
                } elseif ($tickets->ticket_status->name === 'open') {
                    $data .= '<span style="display:inline-block;" class="bg-red-600 text-center text-header-light text-white rounded px-3 py-2 font-inter text-sm">' . ucfirst($tickets->ticket_status->name) . '</span>';
                } elseif ($tickets->ticket_status->name === 'on hold') {
                    $data .= '<span style="display:inline-block;" class="!bg-orange-400 text-center text-header-light text-white rounded px-3 py-2 font-inter text-sm">' . ucfirst($tickets->ticket_status->name) . '</span>';
                } else {
                    $data .= '<span style="display:inline-block;" class="!bg-gray-400 text-center text-header-light text-white rounded px-3 py-2 font-inter text-sm" style="">' . ucfirst($tickets->ticket_status->name) . '</span>';
                }
                return $data;
            })

            ->editColumn('user_id', function ($tickets) {
                $data = "<div class='text-title flex items-center'>
            <img src='" . asset('assets/images/profile.jpg') . "' width='40' height='40' style='border-radius: 50%;border:1px solid #eee' alt='profile'>
            <span class='ml-2'>" . $tickets->user->name . "</span>
         </div>";
                return $data;

            })
            ->editColumn('team_id', function ($tickets) {
                $data = '<span class="text-title">' . @$tickets->team->name . '</span>';
                return $data;
            })
            ->addColumn('agent', function ($tickets) {
                $data = '<span class="text-title">' . @$tickets->owners->last()->name . '</span>';
                return $data;
            })
            ->editColumn('created_at', function ($tickets) {
                $data = '<span class="text-title">' . ISODate($tickets?->created_at) . '</span>';
                return $data;
            })
            ->addColumn('request_age', function ($tickets) {
                $data = '<span class="text-title">' . dayMonthYearHourMininteSecond($tickets?->created_at, true, true, true, true, true, true) . '</span>';
                return $data;
            })
            ->editColumn('due_date', function ($tickets) {
                $data = '<span class="text-title">' . ISOdate($tickets->due_date) . '</span>';
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
        $ticket         = Ticket::query()->where('id', $ticket->id)->with('ticket_notes', 'images', 'conversation')->first();
        $requester_type = RequesterType::query()->get();
        $sources        = Source::query()->get();
        $teams          = Team::query()->get();
        $categories     = Category::where('parent_id', null)->get();
        $ticket_status  = TicketStatus::query()->get();
        $agents         = Team::query()->with('agents')->where('id', $ticket?->team_id)->get();
        $users          = User::whereNotIn('id', [1])->select('id', 'name', 'email')->get();
        $histories      = TicketNote::query()->where('ticket_id', $ticket->id)->select('id', 'note', 'created_at')->get();
        $conversations  = Conversation::orderBy('created_at')->where('parent_id', null)->with('replay')->where('ticket_id', $ticket->id)->get()->groupBy(function ($query) {
            return date('Y m d', strtotime($query->created_at));
        });

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
            'requester_type'   => $requester_type,
            'sources'          => $sources,
            'teams'            => $teams,
            'categories'       => $categories,
            'ticket_status'    => $ticket_status,
            'agents'           => $agents,
            'ticketStatusWise' => $ticketStatusWise,
            'users'            => $users,
            'conversations'    => $conversations,
            'histories'        => $histories,
            'departments'      => Department::where('status', true)->get(),
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
        $queryStatus  = request()->get('ticket_status');
        $categories   = Category::where('status', 1)->get();
        $teams        = Team::where('status', 1)->get();
        $ticketStatus = TicketStatus::where('status', 1)->get();
        return view('ticket.view-all', compact('queryStatus', 'categories', 'teams', 'ticketStatus'));
    }

    public function allListDataTable(Request $request) {
        Gate::authorize('viewAny', Ticket::class);

        $ticketStatus = null;

        if ($request->query_status != 'unassign') {

            $ticketStatus = TicketStatus::where('slug', $request->query_status)->first();
        }

        $tickets = Ticket::query()->with(['owners', 'source', 'user', 'team', 'category', 'ticket_status', 'department']);

        if (Auth::user()->hasRole('requester')) {
            $tickets->where('user_id', Auth::id());
        }

        if ($request->query_status == 'unassign') {

            $tickets->leftJoin('ticket_ownerships as towner', 'tickets.id', '=', 'towner.ticket_id')
                ->where('towner.owner_id', null)
                ->select('tickets.*', 'towner.owner_id');

        } elseif ($ticketStatus->count() > 0 && $ticketStatus->slug == $request->query_status) {

            $tickets->where('ticket_status_id', $ticketStatus->id);

        }

        if ($request->all()) {
            $tickets->where(function ($query) use ($request) {
                if ($request->ticket_id_search) {
                    $query->where('id', 'like', '%' . $request->ticket_id_search . '%');
                }
                if ($request->priority_search) {
                    $query->where('priority', '=', $request->priority_search);
                }
                if ($request->category_search) {
                    $query->where('category_id', '=', $request->category_search);
                }
                if ($request->team_search) {
                    $query->where('team_id', '=', $request->team_search);
                }
                if ($request->status_search) {
                    $query->where('ticket_status_id', '=', $request->status_search);
                }
                if ($request->due_date_search) {
                    $dueDate = '';

                    switch ($request->due_date_search) {
                    case 'today':
                        $todayDate = Carbon::today()->toDateString();
                        $query->whereDate('due_date', '=', $todayDate);
                        break;

                    case 'tomorrow':
                        $tomorrowDate = Carbon::tomorrow()->toDateString();
                        $query->whereDate('due_date', '=', $tomorrowDate);
                        break;

                    case 'this_week':
                        $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
                        $endOfWeek   = Carbon::now()->endOfWeek()->toDateString();
                        $query->whereBetween('due_date', [$startOfWeek, $endOfWeek]);
                        break;

                    case 'this_month':
                        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
                        $endOfMonth   = Carbon::now()->endOfMonth()->toDateString();
                        $query->whereBetween('due_date', [$startOfMonth, $endOfMonth]);
                        break;

                    default:
                        break;
                    }
                }
            });
        }

        return DataTables::of(source: $tickets)
            ->addColumn('select', function () {
                return '<div class="flex items-center justify-center"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #ddd; accent-color: !important #5C5C5C;">
            </div>';
            })
            ->editColumn('title', function ($tickets) {
                return '<a href="' . route('admin.ticket.show', ['ticket' => $tickets?->id]) . '" class="text-title hover:text-amber-500 hover:underline">' . Str::limit(ucfirst($tickets->title), 30, '...') . '</a>';
            })
            ->editColumn('priority', function ($tickets) {
                return '<span class="text-title">' . Str::ucfirst($tickets->priority) . '</span>';
            })
            ->editColumn('category_id', function ($tickets) {
                return '<span class="text-title">' . Str::ucfirst($tickets->category->name) . '</span>';
            })
            ->editColumn('department_id', function ($tickets) {
                return '<span class="text-title">' . Str::ucfirst(@$tickets->department->name) . '</span>';
            })
            ->editColumn('status', function ($tickets) {
                $data = "";
                if ($tickets->ticket_status->name === 'in progress') {
                    $data .= '<span style=";display:inline-block;text-align:center" class="py-2 !bg-process-400 text-white rounded px-3 font-inter text-sm block">' . $tickets->ticket_status->name . '</span>';
                } elseif ($tickets->ticket_status->name === 'open') {
                    $data .= '<span style=";display:inline-block;text-align:center" class="bg-red-600 text-center text-header-light text-white rounded px-3 py-2 font-inter text-sm">' . $tickets->ticket_status->name . '</span>';
                } elseif ($tickets->ticket_status->name === 'on hold') {
                    $data .= '<span style=";display:inline-block;text-align:center" class="py-2 !bg-orange-400 text-white rounded px-3 font-inter text-sm">' . $tickets->ticket_status->name . '</span>';
                } else {
                    $data .= '<span style=";display:inline-block;text-align:center" class="py-2 !bg-gray-400 text-white rounded px-3 font-inter text-sm">' . $tickets->ticket_status->name . '</span>';
                }
                return $data;
            })
            ->editColumn('user_id', function ($tickets) {
                $data = '<div class="text-title flex items-center"><img src="https://i.pravatar.cc/300/5" alt="img" width="25" height="25"
                                style="border-radius: 50%"><span class="ml-2">' . $tickets->user->name . '</span></div>';
                return $data;
            })
            ->editColumn('team_id', function ($tickets) {
                $data = '<span class="text-title">' . @$tickets->team->name . '</span>';
                return $data;
            })
            ->addColumn('agent', function ($tickets) {
                $data = '<span class="text-title">' . @$tickets->owners->last()->name . '</span>';
                return $data;
            })
            ->editColumn('created_at', function ($tickets) {
                $data = '<span class="text-title">' . ISODate($tickets?->created_at) . '</span>';
                return $data;
            })
            ->addColumn('request_age', function ($tickets) {
                $data = '<span class="text-title">' . dayMonthYearHourMininteSecond($tickets?->created_at, true, true, true, true, true, true) . '</span>';
                return $data;
            })
            ->editColumn('due_date', function ($tickets) {
                $data = '<span class="text-title">' . ISOdate($tickets->due_date) . '</span>';
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
            "department_id"    => 'required',
        ]);
        DB::beginTransaction();
        try {
            $ticket_status = TicketStatus::query()->where('id', $ticket->ticket_status_id)->first();

            if ($ticket->owners->isEmpty() || $ticket->owners->last()->id != $request->owner_id) {
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
                $emailResponse['team_change'] = 'Team changed';
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
                $emailResponse['category_change'] = 'Category changed';
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
                $emailResponse['priority'] = 'Priority changed';
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
                $emailResponse['status_change'] = 'Status changed';
            }
            if ($ticket->department_id != $request->department_id) {
                TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'department_change',
                        'note'       => $request->comment,
                        'old_status' => $ticket_status->name,
                        'new_status' => $ticket_status->name,
                        'created_by' => Auth::id(),
                    ]
                );
                $emailResponse['department_change'] = 'Department changed';
            }

            $ticket->update(
                [
                    'priority'         => $request->priority,
                    'due_date'         => $request->due_date,
                    'team_id'          => $request->team_id,
                    'category_id'      => $request->category_id,
                    'ticket_status_id' => $request->ticket_status_id,
                    'department_id'    => $request->department_id,
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

        if (!empty($emailResponse)) {
            Mail::to($ticket->user->email)->send(new LogUpdateMail($emailResponse));
        }
        flash()->success('Data has been updated successfully');
        return back();
    }

    /**
     * Define public method interNoteStore() to add internal notes
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function interNoteStore(Request $request, Ticket $ticket): RedirectResponse {
        $ticket_status = TicketStatus::query()->where('id', $ticket->ticket_status_id)->firstOr();
        $internal_note = TicketNote::create(
            [
                'ticket_id'  => $ticket->id,
                'note_type'  => 'internal_note',
                'note'       => $request->internal_note,
                'old_status' => $ticket_status->name,
                'new_status' => $ticket_status->name,
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
            ]
        );
        $internal_note ? flash()->success('Internal Note has been Added !') : flash()->success('Something went wrong !!!');
        return back();
    }

    /**
     * Define public method to download the file.
     * @param Image $file
     * @return mixed|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFile(Image $file) {
        $filePath = public_path(parse_url($file->url, PHP_URL_PATH));
        return response()->download($filePath);
    }

    /**
     * Define public method conversation() to store the conversation
     * @param Request $request
     * @param Ticket $ticket
     */
    public function conversation(Request $request, Ticket $ticket) {
        $conversation = Conversation::create([
            'ticket_id'         => $ticket->id,
            'requester_id'      => $ticket->user_id,
            'conversation_type' => 'customer',
            'conversation'      => $request->conversation,
            'status'            => 1,
        ]);
        Mail::to($ticket->user->email)->send(new ConversationMail($conversation));
        flash()->success('Conversation has been added successfully');
        return back();
    }

    /**
     * Method for change the owner of ticket
     * @param Request $request
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function ownerChange(Request $request, Ticket $ticket): RedirectResponse {
        $checkUser = User::query()->where('email', $request->requester_email)->first();
        if (!empty($checkUser)) {
            $request->merge([
                'credentials' => false,
            ]);

            $checkUser->update(
                [
                    'phone'             => $request->requester_phone,
                    'name'              => $request->requester_name,
                    'requester_type_id' => $request->requester_type_id,
                    'requester_id'      => $request->requester_id,
                ]
            );
        } else {
            $password = rand(10000000, 99999999);
            $request->merge([
                'credentials' => true,
                'password'    => $password,
            ]);

            $user = User::create([
                'name'              => $request?->requester_name,
                'email'             => $request?->requester_email,
                'phone'             => $request?->requester_phone,
                'password'          => Hash::make($password),
                'requester_type_id' => $request?->requester_type_id,
                'requester_id'      => $request?->requester_id,
            ]);

            $user->assignRole('requester');
            $response = $ticket->update(
                [
                    'user_id' => $user->getKey(),
                ]
            );

            try {
                $ticket_note = TicketNote::create(
                    [
                        'ticket_id'  => $ticket->id,
                        'note_type'  => 'owner_change',
                        'old_status' => $ticket->ticket_note->old_status,
                        'new_status' => $ticket->ticket_note->new_status,
                        'note'       => $ticket->ticket_note->note,
                        'created_by' => $request->user()->id,
                        'updated_by' => $request->user()->id,
                    ]
                );

                TicketLog::create(
                    [
                        'ticket_id'     => $ticket->getKey(),
                        'ticket_status' => $ticket->ticket_status->name,
                        'status'        => 'updated',
                        'comment'       => json_encode($ticket_note),
                        'updated_by'    => Auth::id(),
                        'created_by'    => Auth::id(),
                    ]
                );
            } catch (\Exception $e) {
                TicketLog::create(
                    [
                        'ticket_id'     => $ticket->getKey(),
                        'ticket_status' => $ticket->ticket_status->name,
                        'status'        => 'update_fail',
                        'comment'       => json_encode($e->getMessage()),
                        'updated_by'    => Auth::id(),
                        'created_by'    => Auth::id(),
                    ]
                );
            }
        }
        Mail::to($request->requester_email)->send(new TicketEmail($request));
        flash()->success('Requester Has been added');
        return back();
    }

    /**
     * Define public method partialUpdate() to update partially the ticket
     * @param Request $request
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function partialUpdate(Request $request, Ticket $ticket): RedirectResponse {
        $ticketUpdate = $ticket->update([
            'title'       => $request->request_title,
            'description' => $request->request_description,
            'source_id'   => $request->source_id,
        ]);

        $isUpload = $request->request_attachment ? Fileupload::uploadFile($request, Bucket::TICKET, $ticket->getKey(), Ticket::class) : '';

        try {
            TicketLog::create(
                [
                    'ticket_id'     => $ticket->getKey(),
                    'ticket_status' => $ticket->ticket_status->name,
                    'status'        => 'updated',
                    'comment'       => json_encode($ticketUpdate),
                    'updated_by'    => Auth::id(),
                    'created_by'    => Auth::id(),
                ]
            );
        } catch (\Exception $e) {
            TicketLog::create(
                [
                    'ticket_id'     => $ticket->getKey(),
                    'ticket_status' => $ticket->ticket_status->name,
                    'status'        => 'update_fail',
                    'comment'       => json_encode($e->getMessage()),
                    'updated_by'    => Auth::id(),
                    'created_by'    => Auth::id(),
                ]
            );
        }
        $source          = Source::find($request->source_id);
        $request->source = $source->title;
        Mail::to($ticket->user->email)->send(new UpdateInfoMail($request));
        flash()->success('Edit has been successfully done');
        return back();
    }

    public function categoryWiseSubcategory(Request $request) {
        // return $request->category_id;
        $subCategorys = Category::where('parent_id', $request->category_id)->where('status', 1)->get();

        return $subCategorys;

    }
    public function departmentWiseTeam(Request $request) {
        // return $request->category_id;
        $teams = Team::where('department_id', $request->department_id)->where('status', 1)->get();

        return $teams;

    }
}
