<?php

namespace App\Livewire\Ticket;

use App\Models\Team;
use App\Models\Source;
use Livewire\Component;
use App\Models\TicketStatus;
use App\Models\RequesterType;

class UpdateTicket extends Component
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
     * Define public method mount() to load the resourses
     */
    public function mount(): void
    {
        $this->requester_type = RequesterType::query()->get();
        $this->sources = Source::query()->get();
        $this->teams = Team::query()->get();
        $this->categories = [];
        $this->ticket_status = TicketStatus::query()->get();
        $this->teamAgent = [];
    }

    public function render()
    {
        return view('livewire.ticket.update-ticket');
    }
}
