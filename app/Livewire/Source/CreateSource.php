<?php

namespace App\Livewire\Source;

use App\Models\Source;
use Livewire\Component;
use Livewire\Attributes\Validate;

class CreateSource extends Component {
    #[Validate]
    public $title = '';
    #[Validate]
    public $status = '';

    protected function rules() {
        return [
            'title'  => 'required|unique:sources,title',
            'status' => 'required',
        ];
    }

    public function save() {
        $this->validate();

        Source::create( [
            "title"  => $this->title,
            "status" => $this->status,
        ] );

        flash()->success( 'source Created!' );
        return redirect()->to( '/dashboard/source' );
    }

    public function render() {
        return view( 'livewire.source.create-source' );
    }
}