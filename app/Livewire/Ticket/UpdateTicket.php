<?php

namespace App\Livewire\Ticket;

use App\Enums\Bucket;
use App\Livewire\Forms\TicketUpdateRequest;
use App\LocaleStorage\Fileupload;
use App\Models\Category;
use App\Models\RequesterType;
use App\Models\Source;
use App\Models\Team;
use App\Models\TeamCategory;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Services\Ticket\TicketService;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UpdateTicket extends Component {
    use WithFileUploads;

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
    public function mount(): void {
        /**
         * Old value set to the input field
         */
        $this->ticket                    = Ticket::query()->with('user', 'source', 'image', 'owners')->where('id', $this->ticket->id)->first();
        $this->form->request_title       = $this->ticket?->title;
        $this->form->request_description = $this->ticket?->description;
        $this->form->requester_name      = $this->ticket->user->name;
        $this->form->requester_email     = $this->ticket->user->email;
        $this->form->requester_phone     = $this->ticket->user->phone;
        $this->form->requester_type_id   = $this->ticket->user->requester_type_id;
        $this->form->requester_id        = $this->ticket->user->requester_id;
        $this->form->priority            = $this->ticket->priority;
        $this->form->due_date            = $this->ticket->due_date ? date('Y-m-d', strtotime($this->ticket->due_date)) : '';
        $this->form->source_id           = $this->ticket->source_id;
        $this->form->team_id             = $this->ticket->team_id;
        $this->form->category_id         = $this->ticket->category_id;
        $this->form->ticket_status_id    = $this->ticket->ticket_status_id;
        $this->form->owner_id            = $this->ticket->owners->pluck('id')->toArray();

        /**
         * Select box dynamic value set.
         */
        $this->requester_type = RequesterType::query()->get();
        $this->sources        = Source::query()->get();
        $this->teams          = Team::query()->get();
        $this->categories     = Category::query()->get();
        $this->ticket_status  = TicketStatus::query()->get();
        $this->teamAgent      = Team::query()->with('agents')->where('id', $this->ticket?->team_id)->get();
    }

    /**
     * Define public method selectCategoryAgent() to select category and agent with the
     * change of Team.
     * @return void
     */
    public function selectCategoryAgent(): void {
        $this->categories = TeamCategory::query()->with('category')->where('team_id', $this->form?->team_id)->get();
        $this->teamAgent  = Team::query()->with('agents')->where('id', $this->form?->team_id)->get();
    }

    /**
     * Define public method update() to update the resourses
     */
    public function update(TicketService $service) {

        $this->validate(rules: $this->form->rules(), attributes: $this->form->attributes());
        $isCreate = $service->update($this->ticket, $this->form);

        $isUpload = $this->form->request_attachment ? Fileupload::updateFile($this->form, Bucket::TICKET, $this->ticket, $this->ticket->getKey(), Ticket::class) : '';
        $response = $isCreate ? 'Data has been update successfuly' : 'Something went wrong';
        flash()->success($response);
        return redirect()->to('dashboard/ticket');
    }

    public function render() {
        return view('livewire.ticket.update-ticket');
    }
}