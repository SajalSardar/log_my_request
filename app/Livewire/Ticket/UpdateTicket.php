<?php

namespace App\Livewire\Ticket;

use App\Livewire\Forms\TicketUpdateRequest;
use App\Models\RequesterType;
use App\Models\Source;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Livewire\Component;

class UpdateTicket extends Component
{
    /**
     * Define public form object TicketUpdateRequest $form
     */
    public TicketUpdateRequest $form;

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
     * Define public method mount() to load the resourses
     */
    public function mount(): void
    {
        // dd($this->ticket);
        $this->form->request_title = $this->ticket?->title;
        $this->form->request_description = $this->ticket?->description;
    }

    public function render()
    {
        $this->requester_type = RequesterType::query()->get();
        $this->sources = Source::query()->get();
        $this->teams = Team::query()->get();
        $this->categories = [];
        $this->ticket_status = TicketStatus::query()->get();
        $this->teamAgent = [];

        return view('livewire.ticket.update-ticket');
    }
}
