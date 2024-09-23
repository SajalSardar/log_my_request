<?php

namespace App\Livewire\TicketStatus;

use Livewire\Component;
use App\Models\TicketStatus;
use Livewire\Attributes\Validate;

class CreateTicketStatus extends Component {

    #[Validate]
    public $name = '';
    #[Validate]
    public $status = '';

    protected function rules() {
        return [
            'name'   => 'required|unique:ticket_statuses,name',
            'status' => 'required',
        ];
    }

    public function save() {
        $this->validate();

        TicketStatus::create( [
            "name"   => $this->name,
            "status" => $this->status,
        ] );

        flash()->success( 'Status Created!' );
        return redirect()->to( '/dashboard/ticketstatus' );
    }

    public function render() {
        return view( 'livewire.ticketstatus.create-ticketstatus' );
    }
}