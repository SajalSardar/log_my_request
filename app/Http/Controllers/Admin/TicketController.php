<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Bucket;
use App\Http\Controllers\Controller;
use App\LocaleStorage\Fileupload;
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
use Illuminate\Auth\Events\Registered;
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

        $tickets = Ticket::query()
            ->with(['owners', 'source', 'user', 'team', 'category', 'sub_category', 'ticket_status', 'department']);
        if (Auth::user()->hasRole(['requester', 'Requester'])) {
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
                return '<div class="flex items-center justify-center"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #9b9b9b; accent-color: !important #5C5C5C;">
                </div>';
            })
            ->editColumn('id', function ($tickets) {
                return '<span class="text-paragraph">' . '#' . $tickets->id . '</span>';
            })
            ->editColumn('title', function ($tickets) {
                return '<a href="' . route('admin.ticket.show', ['ticket' => $tickets?->id]) . '" class="pr-4 text-paragraph hover:text-orange-300 hover:underline block" style="width: 325px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . Str::limit(ucfirst($tickets->title), 50, '...') . '</a>';
            })
            ->editColumn('priority', function ($tickets) {
                $priorityColor = match ($tickets->priority) {
                    'high' => '#EF4444',
                    'low'    => '#10B981',
                    'medium' => '#3B82F6',
                };
                return '<span style="color: ' . $priorityColor . '; padding: 5px; border-radius: 4px;" class="text-paragraph !font-semibold w-20 pr-3 block">' . Str::ucfirst($tickets->priority) . '</span>';
            })
            ->editColumn('department_id', function ($tickets) {
                return '<span class="text-paragraph w-40 block pr-3">' . Str::ucfirst(@$tickets->department->name) . '</span>';
            })
            ->editColumn('category_id', function ($tickets) {
                return '<span class="text-paragraph w-44 block pr-4">' . Str::ucfirst(@$tickets->category->name) . '</span>';
            })
            ->editColumn('sub_category_id', function ($tickets) {
                return '<span class="text-paragraph w-44 block pr-4">' . Str::ucfirst(@$tickets->sub_category->name) . '</span>';
            })
            ->editColumn('ticket_status_id', function ($tickets) {
                $data = "";
                if ($tickets->ticket_status->slug === 'resolved') {
                    $data .= '<div style="width: 156px;"><span class="py-2 !bg-resolved-400 text-paragraph !font-semibold rounded px-3">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'closed') {
                    $data .= '<div style="width: 156px;"><span class="bg-closed-400 text-left text-header-light text-paragraph !font-semibold rounded px-3 py-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'open') {
                    $data .= '<div style="width: 156px;"><span class="py-2 !bg-open-400 text-paragraph !font-semibold rounded px-3">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'in-progress') {
                    $data .= '<div style="width: 156px;"><span class="py-2 !bg-inProgress-400 text-paragraph !font-semibold rounded px-3">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'on-hold') {
                    $data .= '<div style="width: 156px;"><span class="py-2 !bg-hold-400 text-paragraph !font-semibold rounded px-3">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } else {
                    $data .= '<div style="width: 156px;"><span class="py-2 !bg-gray-400 text-paragraph !font-semibold rounded px-3">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                }
                return $data;
            })
            ->editColumn('user_id', function ($tickets) {
                $data = "<div style='width:163px' class='text-paragraph flex items-center'>
            <img src='" . asset('assets/images/profile.jpg') . "' width='40' height='40' style='border-radius: 50%;border:1px solid #eee' alt='profile'>
            <span class='ml-2'>" . $tickets->user->name . "</span>
         </div>";
                return $data;
            })
            ->editColumn('team_id', function ($tickets) {
                $data = '<span class="text-paragraph">' . @$tickets->team->name . '</span>';
                return $data;
            })
            ->addColumn('agent', function ($tickets) {
                $data = '<span class="text-paragraph" style="width:138px">' . @$tickets->owners->last()->name . '</span>';
                return $data;
            })
            ->editColumn('created_at', function ($tickets) {
                $data = '<span class="text-paragraph" style="width:120px">' . ISODate($tickets?->created_at) . '</span>';
                return $data;
            })
            ->addColumn('request_age', function ($tickets) {
                $data = '<span class="text-paragraph">' . dayMonthYearHourMininteSecond($tickets?->created_at, $tickets?->resolved_at, true, true, true, true) . '</span>';
                return $data;
            })
            ->editColumn('due_date', function ($tickets) {
                $data = '<span class="text-paragraph" style="width:103px">' . ISOdate($tickets->due_date) . '</span>';
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
                                        href="' . route('admin.ticket.edit', $tickets?->id) . '">Edit</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-white">
                                    <a
                                        href="' . route('admin.ticket.show', $tickets?->id) . '">View</a>
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
     * Display the specified resource.
     */
    public function show(Request $request, Ticket $ticket) {
        if ($request->ajax()) {
            $agents = Team::query()->with('agents')->where('id', $request->team_id)->get();
            return response()->json($agents);
        }
        Gate::authorize('view', $ticket);

        $requester_type = RequesterType::query()->get();
        $sources        = Source::query()->get();
        $teams          = Team::query()->get();
        $categories     = Category::where('parent_id', null)->get();
        $ticket_status  = TicketStatus::query()->get();
        $agents         = Team::query()->with('agents')->where('id', $ticket?->team_id)->get();
        $users          = User::whereNotIn('id', [1])->select('id', 'name', 'email')->get();
        $departments    = Department::where('status', true)->get();

        $ticket = Ticket::where('id', $ticket->id)
            ->with(['ticket_notes' => function ($q) {
                $q->orderBy('id', 'desc');
            }, 'conversation' => function ($q) {
                $q->orderBy('created_at', 'desc');
            }, 'conversation.creator', 'conversation.replay', 'ticket_notes.creator', 'images'])
            ->first();

        $conversations = $ticket->conversation->where('parent_id', null)->groupBy(function ($query) {
            return date('Y m d', strtotime($query->created_at));
        });

        $histories     = $ticket->ticket_notes->whereNotIn('note_type', ['internal_note']);
        $internalNotes = $ticket->ticket_notes->where('note_type', 'internal_note');

        $data = [
            'ticket'         => $ticket,
            'requester_type' => $requester_type,
            'sources'        => $sources,
            'teams'          => $teams,
            'categories'     => $categories,
            'ticket_status'  => $ticket_status,
            'agents'         => $agents,
            'users'          => $users,
            'conversations'  => $conversations,
            'histories'      => $histories,
            'departments'    => $departments,
            'internalNotes'  => $internalNotes,
        ];
        return view('ticket.show', $data);
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
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket) {
        Gate::authorize('delete', $ticket);
    }

    public function ticketList() {
        Gate::authorize('viewAny', Ticket::class);
        $queryStatus  = request()->get('request_status');
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

        $tickets = Ticket::query()->with(['owners', 'source', 'user', 'team', 'category', 'sub_category', 'ticket_status', 'department']);

        if (Auth::user()->hasRole(['requester', 'Requester'])) {
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
                return '<div class="flex items-center justify-center"><input type="checkbox" class ="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #9b9b9b; accent-color: #5C5C5C !important;"></div>';
            })
            ->editColumn('id', function ($tickets) {
                return '<span class="text-paragraph">' . '#' . $tickets->id . '</span>';
            })
            ->editColumn('title', function ($tickets) {
                return '<a href="' . route('admin.ticket.show', ['ticket' => $tickets?->id]) . '" class="text-paragraph hover:text-amber-500 hover:underline" style="width: 325px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . Str::limit(ucfirst($tickets->title), 30, '...') . '</a>';
            })
            ->editColumn('priority', function ($tickets) {
                $priorityColor = match ($tickets->priority) {
                    'high' => '#EF4444',
                    'low'    => '#10B981',
                    'medium' => '#3B82F6',
                };
                return '<span style="color: ' . $priorityColor . '; padding: 5px; border-radius: 4px;" class="text-paragraph !font-semibold w-20 pr-3 block">' . Str::ucfirst($tickets->priority) . '</span>';
            })
            ->editColumn('category_id', function ($tickets) {
                return '<span class="text-paragraph">' . Str::ucfirst($tickets->category->name) . '</span>';
            })
            ->editColumn('sub_category_id', function ($tickets) {
                return '<span class="text-paragraph w-44 block pr-4">' . Str::ucfirst(@$tickets->sub_category->name) . '</span>';
            })
            ->editColumn('department_id', function ($tickets) {
                return '<span class="text-paragraph">' . Str::ucfirst(@$tickets->department->name) . '</span>';
            })
            ->editColumn('status', function ($tickets) {
                $data = "";
                if ($tickets->ticket_status->slug === 'resolved') {
                    $data .= '<div style="width: 156px;"><span class="py-2 !bg-resolved-400 text-paragraph !font-semibold rounded px-3">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'closed') {
                    $data .= '<div style="width: 156px;"><span class="bg-closed-400 text-left text-header-light text-paragraph !font-semibold rounded px-3 py-2">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'open') {
                    $data .= '<div style="width: 156px;"><span class="py-2 !bg-open-400 text-paragraph !font-semibold rounded px-3">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'in-progress') {
                    $data .= '<div style="width: 156px;"><span class="py-2 !bg-inProgress-400 text-paragraph !font-semibold rounded px-3">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } elseif ($tickets->ticket_status->slug === 'on-hold') {
                    $data .= '<div style="width: 156px;"><span class="py-2 !bg-hold-400 text-paragraph !font-semibold rounded px-3">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                } else {
                    $data .= '<div style="width: 156px;"><span class="py-2 !bg-gray-400 text-paragraph !font-semibold rounded px-3">' . Str::ucfirst($tickets->ticket_status->name) . '</span></div>';
                }
                return $data;
            })
            ->editColumn('user_id', function ($tickets) {
                $data = "<div style='width:163px' class='text-paragraph flex items-center'>
                <img src='" . asset('assets/images/profile.jpg') . "' width='40' height='40' style='border-radius: 50%;border:1px solid #eee' alt='profile'>
                <span class='ml-2'>" . $tickets->user->name . "</span>
            </div>";
                return $data;
            })
            ->editColumn('team_id', function ($tickets) {
                $data = '<span class="text-paragraph">' . @$tickets->team->name . '</span>';
                return $data;
            })
            ->addColumn('agent', function ($tickets) {
                $data = '<span class="text-paragraph" style="width:138px">' . @$tickets->owners->last()->name . '</span>';
                return $data;
            })
            ->editColumn('created_at', function ($tickets) {
                $data = '<span class="text-paragraph" style="width:120px">' . ISODate($tickets?->created_at) . '</span>';
                return $data;
            })
            ->addColumn('request_age', function ($tickets) {
                $data = '<span class="text-paragraph">' . dayMonthYearHourMininteSecond($tickets?->created_at, $tickets?->resolved_at, true, true, true, true) . '</span>';
                return $data;
            })
            ->editColumn('due_date', function ($tickets) {
                $data = '<span class="text-paragraph" style="width:103px">' . ISOdate($tickets->due_date) . '</span>';
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
                                        href="' . route('admin.ticket.edit', $tickets->id) . '">Edit</a>
                                </li>
                                <li class="px-5 py-1 text-center bg-white">
                                    <a
                                        href="' . route('admin.ticket.show', $tickets->id) . '">View</a>
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
        $emailResponse = [];
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

                $ticket_agents                 = $ticket->owners()->attach($request->owner_id);
                $emailResponse['owner_change'] = 'Owner changed';
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
                $emailResponse['due_date_change'] = 'Due date changed';
            }
            if ($ticket->ticket_status_id != $request->ticket_status_id) {

                $checkTicketStatus = TicketStatus::where('id', $request->ticket_status_id)->first();

                if ($checkTicketStatus->slug == 'resolved') {
                    $resolution_now        = Carbon::now();
                    $resolution_in_seconds = $ticket->created_at->diffInSeconds($resolution_now);
                    $ticket->update([
                        'resolution_time' => (int) $resolution_in_seconds,
                        'resolved_at'     => now(),
                        'resolved_by'     => Auth::id(),
                    ]);
                } else {
                    $ticket->update([
                        'resolution_time' => null,
                        'resolved_at'     => null,
                        'resolved_by'     => null,
                    ]);
                }

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
                    'sub_category_id'  => $request->sub_category_id,
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
            Mail::to($ticket->user->email)->queue(new LogUpdateMail($emailResponse));
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
     * Method for change the owner of ticket
     * @param Request $request
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function ticketRequesterChange(Request $request, Ticket $ticket): RedirectResponse {
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

            $ticket->update(
                [
                    'user_id' => $checkUser->id,
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

            $ticket->update(
                [
                    'user_id' => $user->getKey(),
                ]
            );

            event(new Registered($user));
        }

        try {
            $ticket_note = TicketNote::create(
                [
                    'ticket_id'  => $ticket->id,
                    'note_type'  => 'requester_change',
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
        $source = Source::find($request->source_id);

        Mail::to($ticket->user->email)->queue(new UpdateInfoMail($ticket));
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
