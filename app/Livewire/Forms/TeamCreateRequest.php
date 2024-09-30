<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class TeamCreateRequest extends Form
{
    #[Validate]
    public $name;

    #[Validate]
    public $status;

    #[Validate]
    public $category_id;

    #[Validate]
    public $image;

    #[Validate]
    public $agent_id = [];

    protected function rules()
    {
        return [
            'name' => 'required|min:3|unique:categories,name',
            'status' => 'required|string:0,1',
            'category_id' => 'nullable',
            'agent_id' => 'nullable',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:3024',
        ];
    }
}
