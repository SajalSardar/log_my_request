<?php

namespace App\Livewire\Team;

use App\Models\Team;
use Livewire\Component;
use App\LocaleStorage\Fileupload;
use App\Services\Team\TeamService;
use App\Livewire\Forms\TeamCreateRequest;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateTeam extends Component
{
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
     * Define public method save() to store the resourses
     * @return void
     */
    public function save(TeamService $service): void
    {
        $this->form->validate();
        $isCreate = $service->store($this->form);
        $isUpload = Fileupload::upload($this->form, $isCreate->getKey(), Team::class,  300,  300);
        $response = ($isUpload && $isCreate) ? 'Data has been update successfuly' : 'Something went wrong';
        flash()->success($response);
        $this->form->reset();
    }
    
    public function render()
    {
        return view('livewire.team.create-team');
    }
}
