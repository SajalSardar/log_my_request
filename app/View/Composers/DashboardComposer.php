<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Models\Team;
use App\Models\Ticket;
use Illuminate\View\View;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardComposer
{
    public array|object $responses;

    /**
     * Create a new profile composer.
     */
    public function __construct()
    {
        $this->responses['requests'] = DB::table('ticket_statuses as status')
            ->leftJoin('tickets as ticket', 'status.id', '=', 'ticket.ticket_status_id')
            ->select(DB::raw('count(ticket.id) as count, status.name'))
            ->groupBy('status.name')
            ->get();

        $totalTickets = DB::table('tickets')->count();
        $this->responses['charts'] = DB::table('tickets')
            ->select('priority', DB::raw('count(*) as count'))
            ->groupBy('priority')
            // ->orderBy('priority')
            ->get()
            ->map(function ($item) use ($totalTickets) {
                $color = '';
                switch ($item->priority) {
                    case 'low':
                        $color = '#10B981';
                        break;
                    case 'medium':
                        $color = '#3B82F6';
                        break;
                    case 'high':
                        $color = '#EF4444';
                        break;
                    default:
                        $color = 'orange';
                }

                return [
                    'value' => (int) number_format(round($item->count / $totalTickets * 100), 2),
                    'color' => $color,
                    'priority' => ucfirst($item->priority),
                ];
            });

        $this->responses['requesters'] = User::query()
            ->withCount('requester_tickets')
            ->orderBy('requester_tickets_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'total' => $user->requester_tickets_count,
                ];
            });

        $this->responses['agents'] = User::query()
            ->withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'total' => $user->tickets_count,
                ];
            });

        $this->responses['categories'] = Category::query()
            ->withCount('ticket')
            ->orderBy('ticket_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'total' => $user->ticket_count,
                ];
            });

        $this->responses['teams'] = Team::query()
            ->withCount('ticket')
            ->orderBy('ticket_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'total' => $user->ticket_count,
                ];
            });

        // dd($this->responses);
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('responses', (object) $this->responses);
    }
}
