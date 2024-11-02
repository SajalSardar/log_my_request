<?php

namespace App\View\Composers;

use App\Models\Ticket;
use Illuminate\View\View;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\DB;

class DashboardComposer
{

    public array|object $responses;

    /**
     * Create a new profile composer.
     */
    public function __construct()
    {
        $this->responses = DB::table('ticket_statuses as status')
            ->leftJoin('tickets as ticket', 'status.id', '=', 'ticket.ticket_status_id')
            ->select(DB::raw('count(*) as count, name'))
            ->groupBy('name')
            ->get();


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