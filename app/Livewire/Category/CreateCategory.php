<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\LocaleStorage\Fileupload;
use App\Services\Category\CategoryService;
use App\Livewire\Forms\CategoryCreateRequest;
use App\Models\Category;

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
    public function save(CategoryService $service): void
    {
        $this->form->validate();
        $isCreate = $service->store($this->form);
        $isUpload = Fileupload::upload($this->form, $isCreate->getKey(), Category::class);
        $response = ($isUpload && $isCreate) ? 'Data has been update successfuly' : 'Something went wrong';
        flash()->success($response);
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.category.create-category');
    }
}
