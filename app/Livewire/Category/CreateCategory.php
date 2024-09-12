<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\CategoryCreateRequest;

class CreateCategory extends Component
{
    use WithFileUploads;
    /**
     * Define public property $parent_categories;
     * @var array|object
     */
    public array|object $parent_categories;

    /**
     * Define public form object CategoryCreateRequest $form
     */
    public CategoryCreateRequest $form;

    /**
     * Define public method save() to save the resourses
     * @return void
     */
    public function save(): void
    {
        $this->form->validate();
        dd($this->form);
    }

    public function render()
    {
        return view('livewire.category.create-category');
    }
}
