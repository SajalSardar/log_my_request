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
     */
    public function save(TeamService $service)
    {
        $this->form->validate();
        $isCreate = $service->store($this->form);
        $isUpload = $this->form->image ? Fileupload::upload($this->form, $isCreate->getKey(), Team::class,  300,  300): '';
        $response =  $isCreate ? 'Data has been update successfuly' : 'Something went wrong';
        flash()->success($response);
        return redirect()->to('/dashboard/team');
    }
    
    public function render()
    {
        return view('livewire.team.create-team');
    }
}
