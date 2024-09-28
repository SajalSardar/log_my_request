<?php

namespace App\Livewire\Team;

use App\Enums\Bucket;
use App\Livewire\Forms\TeamCreateRequest;
use App\LocaleStorage\Fileupload;
use App\Models\Team;
use App\Services\Team\TeamService;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateTeam extends Component {
    use WithFileUploads;

    /**
     * Define public form object TeamCreateRequest $form
     */
    public TeamCreateRequest $form;

    /**
     * Define public property $categories
     * @var array|object
     */
    public $categories;

    /**
     * Define public property $categories
     * @var array|object
     */
    public $agentUser;

    /**
     * Define public method save() to store the resourses
     */
    public function save(TeamService $service) {
        $this->form->validate();
        $isCreate = $service->store($this->form);
        $isUpload = $this->form->image ? Fileupload::upload($this->form, Bucket::TEAM, $isCreate->getKey(), Team::class, 300, 300) : '';
        $response = $isCreate ? 'Data has been update successfuly' : 'Something went wrong';
        flash()->success($response);
        return redirect()->to('/dashboard/team');
    }

    public function render()
    {
        return view('livewire.team.create-team');
    }

}
