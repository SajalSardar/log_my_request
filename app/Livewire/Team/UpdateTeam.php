<?php

namespace App\Livewire\Team;

use App\Models\Team;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateTeam extends Component {

    public $team;
    public $agentUser;
    public $categories;

    #[Validate]
    public $name;

    #[Validate]
    public $status;

    #[Validate]
    public $categories_input = [];

    #[Validate]
    public $image;

    #[Validate]
    public $agent_id = [];

    protected function rules() {
        return [
            'name'             => 'required|min:3|unique:categories,name,' . $this->team->id,
            'status'           => 'required|string:0,1',
            'categories_input' => 'nullable',
            'agent_id'         => 'nullable',
            'image'            => 'nullable|mimes:jpg,jpeg,png|max:3024',
        ];
    }

    public function mount(): void {
        $this->name             = $this->team->name;
        $this->status           = $this->team->status;
        $this->categories_input = $this->team->teamCategories->pluck('id')->toArray();
        $this->agent_id         = $this->team->agents->pluck('id')->toArray();
    }
    public function update() {
        Gate::authorize('update', Team::class);
        dd($this->categories_input);
        $this->validate();
        $this->team->update([
            'name'   => $this->name,
            'slug'   => Str::slug($this->name),
            'status' => $this->status,
        ]);
        $this->team->teamCategories()->sync($this->categories_input);

        $this->team->agents()->sync($this->agent_id);

        // $this->image ? Fileupload::upload($this->form, Bucket::TEAM, $team->getKey(), Team::class, 300, 300) : '';

        flash()->success('Data has been update successfuly');
        return redirect()->to('/dashboard/team');
    }
    public function render() {
        Gate::authorize('update', Team::class);
        return view('livewire.team.update-team');
    }
}