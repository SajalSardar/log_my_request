<?php

namespace App\Livewire\RequesterType;

use Livewire\Component;
use App\Models\RequesterType;
use Livewire\Attributes\Validate;

class CreateRequesterType extends Component {

    #[Validate]
    public $name = '';
    #[Validate]
    public $status = '';

    protected function rules() {
        return [
            'name'   => 'required|unique:requester_types,name',
            'status' => 'required',
        ];
    }

    public function save() {
        $this->validate();

        RequesterType::create( [
            "name"   => $this->name,
            "status" => $this->status,
        ] );

        flash()->success( 'source Created!' );
        return redirect()->to( '/dashboard/requestertype' );
    }

    public function render() {
        return view( 'livewire.requestertype.create-requestertype' );
    }
}