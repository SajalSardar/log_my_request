<?php

namespace App\Livewire\Department;

use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateDepartment extends Component {

    /**
     * Define public property $menu
     */
    public $department;

    #[Validate]
    public $name = '';
    #[Validate]
    public $status = '';

    protected function rules() {
        return [
            'name'   => 'required|min:3|unique:departments,name,' . $this->department->id,
            'status' => 'required',
        ];
    }

    /**
     * Define public function mount()
     */
    public function mount(): void {
        $this->name   = $this->department->name;
        $this->status = $this->department->status;
    }
    /**
     * Define public method update()
     * @return void
     */
    public function update() {

        $this->validate();

        $this->department->update([
            "name"   => $this->name,
            "slug"   => Str::slug($this->name),
            "status" => $this->status,
        ]);

        flash()->success('Department Updated!');
        return redirect()->to('/dashboard/department');
    }

    public function render() {
        return view('livewire.department.update-department');
    }
}