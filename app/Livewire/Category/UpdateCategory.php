<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Livewire\Forms\CategoryUpdateRequest;

class UpdateCategory extends Component
{
    /**
     * Define public property $parent_categories;
     * @var array|object
     */
    public array|object $parent_categories;

    /**
     * Define public property $category;
     * @var array|object
     */
    public array|object $category;

    /**
     * Define public form object CategoryCreateRequest $form
     */
    public CategoryUpdateRequest $form;

    /**
     * Define public method mount()
     * @return void
     */
    public function mount()
    {
        $this->form->ignore = $this->category->id;
        $this->form->name   = $this->category?->name;
        $this->form->status = $this->category?->status;
    }

    /**
     * Define public method update()
     * @return void
     */
    public function update()
    {
        $this->validate(rules: $this->form->rules());
    }


    public function render()
    {
        return view('livewire.category.update-category');
    }
}
