<?php

namespace App\Services\Ticket;

use App\Mail\LogUpdateMail;
use App\Mail\TicketEmail;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\TicketNote;
use App\Models\TicketOwnership;
use App\Models\TicketStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TicketService {
    /**
     * Define public property $user;
     * @var array|object
     */
    public $user = [];

    /**
     * Define public property $password;
     * @var string
     */
    public $password;

    /**
     * Define public method store to save the resourses
     * @param $form
     * @return array|object
     */
    public function store(array | object $request): array | object {

        $checkUser = User::query()->where('email', $request->requester_email)->first();
        if (!empty($checkUser)) {
            $request->credentials = false;
            $checkUser->update(
                [
                    'phone'             => $request->requester_phone,
                    'name'              => $request->requester_name,
                    'requester_type_id' => $request->requester_type_id,
                    'requester_id'      => $request->requester_id,
                ]
            );
        } else {
            $this->password       = rand(10000000, 99999999);
            $request->credentials = true;
            $request->password    = $this->password;
            $this->user           = User::create([
                'name'              => $request?->requester_name,
                'email'             => $request?->requester_email,
                'phone'             => $request?->requester_phone,
                'password'          => Hash::make($this->password),
                'requester_type_id' => $request?->requester_type_id,
                'requester_id'      => $request?->requester_id,
            ]);
            $this->user->assignRole('requester');
            event(new Registered($this->user));

        }

        $response = Ticket::create(
            [
                'user_id'          => $checkUser ? $checkUser->id : $this->user->id,
                'department_id'    => $request?->department_id,
                'team_id'          => $request?->team_id,
                'category_id'      => $request?->category_id,
                'ticket_status_id' => $request?->ticket_status_id,
                'source_id'        => $request?->source_id,
                'title'            => $request?->request_title,
                'description'      => $request?->request_description,
                'priority'         => $request?->priority,
                'ticket_type'      => 'customer',
                'due_date'         => $request?->due_date,
                'created_by'       => Auth::id(),
                'sub_category_id'  => $request?->sub_category_id,
            ]
        );

        $ticketStatus = $this->getTicketStatusById($request?->ticket_status_id);

        $this->createTicketNote($response->getKey(), $ticketStatus?->name, $ticketStatus?->name, 'initiated', $request?->request_description);

        $this->createTicketLog($response->getKey(), $ticketStatus->name, 'create', json_encode($response));

        if ($request->owner_id) {
            $response->owners()->attach($request->owner_id);
        }

        Mail::to($request->requester_email)->queue(new TicketEmail($request));

        return $response;
    }

    /**
     * Define public method update to update the resourses
     * @param Model $model
     * @param $request
     * @return array|object|bool
     */
    public function update(Model $model, $request) {

        $ticket        = Ticket::with('owners')->where('id', $model->getKey())->first();
        $requester     = User::where('email', $request->requester_email)->first();
        $emailResponse = null;
        DB::beginTransaction();
        try {
            if (!empty($requester)) {
                $requester->update(
                    [
                        'phone'             => $request->requester_phone,
                        'name'              => $request->requester_name,
                        'requester_type_id' => $request->requester_type_id,
                        'requester_id'      => $request->requester_id,
                    ]
                );
            }

            $ticket_status = $this->getTicketStatusById($ticket?->ticket_status_id);
            $emailResponse = $this->ticketChangesNote($request, $ticket, $ticket_status);

            $ticket->update(
                [
                    'department_id'    => $request?->department_id,
                    'source_id'        => $request->source_id,
                    'title'            => $request->request_title,
                    'description'      => $request->request_description,
                    'priority'         => $request->priority,
                    'due_date'         => $request->due_date,
                    'team_id'          => $request->team_id,
                    'category_id'      => $request->category_id,
                    'ticket_status_id' => $request->ticket_status_id,
                    'updated_by'       => Auth::id(),
                    'sub_category_id'  => $request?->sub_category_id,
                ]
            );

            $this->createTicketLog($ticket->getKey(), $ticket_status->name, 'updated', json_encode($ticket));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->createTicketLog($ticket->getKey(), $ticket_status->name, 'update_fail', json_encode($e->getMessage()));
        }

        if (!empty($emailResponse)) {
            Mail::to($ticket->user->email)->queue(new LogUpdateMail($emailResponse));
        }

        return $ticket;
    }

    public static function createTicketNote($ticketId, $old_status = null, $new_status = null, $note_type, $note = null) {
        $note = TicketNote::create(
            [
                'ticket_id'  => $ticketId,
                'note_type'  => $note_type,
                'note'       => $note,
                'old_status' => $old_status,
                'new_status' => $new_status,
                'created_by' => Auth::id(),
            ]
        );

        return $note;
    }
    public static function createTicketLog($ticketId, $ticket_status, $status = null, $comment = null) {
        $log = TicketLog::create(
            [
                'ticket_id'     => $ticketId,
                'ticket_status' => $ticket_status,
                'status'        => $status,
                'comment'       => $comment,
                'updated_by'    => Auth::id(),
                'created_by'    => Auth::id(),
            ]
        );

        return $log;
    }

    public static function getTicketStatusById($id) {
        $ticketStatus = TicketStatus::where('id', $id)->first();
        if ($ticketStatus) {

            return $ticketStatus;
        }
        return "Status Not Found!";
    }

    public static function ticketChangesNote($request, $ticket, $ticket_status) {

        $emailResponse = [];
        if ($request->owner_id && ($ticket->owners->isEmpty() || $ticket->owners->last()->id != $request->owner_id)) {

            $last_owner = TicketOwnership::where('ticket_id', $ticket->id)->where('duration', null)->orderBy('id', 'desc')->first();
            if ($last_owner && $request->owner_id) {
                $now                 = Carbon::now();
                $duration_in_seconds = $last_owner->created_at->diffInSeconds($now);
                $last_owner->update([
                    'duration' => $duration_in_seconds,
                ]);
            }

            $ticket->owners()->attach($request->owner_id);
            $note = $request->comment ? $request->comment : 'Owner changed';

            TicketService::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'owner_change', $note);

            $emailResponse['owner_change'] = 'Owner changed';
        }
        if ($ticket->team_id != $request->team_id) {
            $note = $request->comment ? $request->comment : 'Team changed';
            TicketService::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'team_change', $note);
            $emailResponse['team_change'] = 'Team changed';
        }
        if ($ticket->category_id != $request->category_id) {
            $note = $request->comment ? $request->comment : 'Category changed';
            TicketService::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'category_change', $note);

            $emailResponse['category_change'] = 'Category changed';
        }
        if ($ticket->priority != $request->priority) {
            $note = $request->comment ? $request->comment : 'Priority changed';
            TicketService::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'priority_change', $note);
            $emailResponse['priority'] = 'Priority changed';
        }

        $old_due_date = $ticket->due_date ? $ticket->due_date->format('Y-m-d') : '';
        if (empty($old_due_date) || $old_due_date != $request->due_date) {
            $note = $request->comment ? $request->comment : 'Due Date changed';
            TicketService::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'due_date_change', $note);

            $emailResponse['due_date_change'] = 'Due date changed';
        }
        if ($ticket->ticket_status_id != $request->ticket_status_id) {

            $checkTicketStatus = TicketService::getTicketStatusById($request->ticket_status_id);

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
            $note = $request->comment ? $request->comment : 'Status changed';
            TicketService::createTicketNote($ticket->id, $ticket->ticket_status->name, $checkTicketStatus->name, 'status_change', $note);

            $emailResponse['status_change'] = 'Status changed';
        }

        if ($ticket->department_id != $request->department_id) {
            $note = $request->comment ? $request->comment : 'Department changed';
            TicketService::createTicketNote($ticket->id, $ticket_status->name, $ticket_status->name, 'department_change', $note);

            $emailResponse['department_change'] = 'Department changed';
        }

        return $emailResponse;
    }

    public static function allTicketListDataTable($request) {

        $ticketStatus = null;

        if ($request->query_status != 'unassign') {

            $ticketStatus = TicketStatus::where('slug', $request->query_status)->first();
        }

        $tickets = Ticket::query()
            ->with(['owners', 'source', 'user', 'team', 'category', 'sub_category', 'ticket_status', 'department']);

        if (Auth::user()->hasRole(['requester', 'Requester'])) {
            $tickets->where('user_id', Auth::id());
        }

        if ($request->query_status == 'unassign') {

            $tickets->leftJoin('ticket_ownerships as towner', 'tickets.id', '=', 'towner.ticket_id')
                ->where('towner.owner_id', null)
                ->select('tickets.*', 'towner.owner_id');
        } elseif ($ticketStatus && $ticketStatus->slug == $request->query_status) {

            $tickets->where('ticket_status_id', $ticketStatus->id);
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
}
