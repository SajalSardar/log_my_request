<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;

class TeamCreateRequest extends Form
{
    #[Validate('required|max:20')]
    public $name;

    #[Validate('required|string:0,1')]
    public $status;

    #[Validate('nullable')]
    public $category_id;

    #[Validate('nullable|mimes:jpg,jpeg,png|max:3024')]
    public $image;
}
