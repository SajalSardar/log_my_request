<?php

namespace App\Livewire\Ticket;

use App\Enums\Bucket;
use App\Livewire\Forms\TicketCreateRequest;
use App\LocaleStorage\Fileupload;
use App\Models\Category;
use App\Models\RequesterType;
use App\Models\Source;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Services\Ticket\TicketService;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateTicket extends Component {
    use WithFileUploads;

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
    public function mount(): void {
        $this->requester_type = RequesterType::query()->get();
        $this->sources        = Source::query()->get();
        $this->teams          = Team::query()->get();
        $this->categories     = Category::query()->get();
        $this->ticket_status  = TicketStatus::query()->get();
        $this->teamAgent      = [];
    }

    /**
     * Define public method selectCategoryAgent() to select category and agent with the
     * change of Team.
     * @return void
     */
    public function selectCategoryAgent(): void {
        $this->teamAgent = Team::query()->with('agents')->where('id', $this->form?->team_id)->get();
    }

    /**
     * Define public method save() to store the resourses
     * @return void
     */
    public function save(TicketService $service) {

        $this->validate(rules: $this->form->rules(), attributes: $this->form->attributes());
        $isCreate = $service->store($this->form);
        $isUpload = $this->form->request_attachment ? Fileupload::uploadFile($this->form, Bucket::TICKET, $isCreate->getKey(), Ticket::class) : '';
        $response = $isCreate ? 'Data has been update successfuly' : 'Something went wrong';
        flash()->success($response);

        return redirect()->to('dashboard/ticket');
    }

    public function render() {
        return view('livewire.ticket.create-ticket');
    }
}
