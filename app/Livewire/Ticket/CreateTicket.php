<?php

namespace App\Livewire\Ticket;

use App\Livewire\Forms\TicketCreateRequest;
use App\Models\Category;
use App\Models\RequesterType;
use App\Models\Source;
use App\Models\Team;
use Livewire\Component;

class CreateTicket extends Component
{
    /**
     * Define public form object TicketCreateRequest $form
     */
    public TicketCreateRequest $form;

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
     * Define public method mount() to load the resourses
     */
    public function mount(): void
    {
        $this->requester_type = RequesterType::query()->get();
        $this->sources = Source::query()->get();
        $this->categories = Category::query()->get();
        $this->teams = Team::query()->get();
    }

    /**
     * Define public method save() to store the resourses
     * @return void
     */
    public function save(): void
    {
        dd($this->form);
    }

    public function render()
    {
        return view('livewire.ticket.create-ticket');
    }
}
