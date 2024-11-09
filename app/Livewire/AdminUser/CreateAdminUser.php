<?php

namespace App\Livewire\AdminUser;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Services\AdminUser\AdminUserService;
use App\Livewire\Forms\AdminUserCreateRequest;


class CreateAdminUser extends Component
{
    /**
     * Define public form method AdminUserCreateRequest $form;
     */
    public AdminUserCreateRequest $form;

    /**
     * Define public property $roles
     * @var array|object
     */
    public array|object $roles;

    /**
     * Define public method save() to store the resources
     * @param AdminUserService $service
     * @return void
     */
    public function save(AdminUserService $service): void
    {
        $this->form->validate();
        $isCreate = $service->store($this->form);
        $response = $isCreate ? 'Data has been submit successfully !' : 'Something went wrong !';
        flash()->success($response);
        $this->form->reset();
    }

    public function render()
    {
        $this->roles = Role::query()->whereNotIn('id', [1])->get();
        return view('livewire.adminuser.create-adminuser');
    }
}
