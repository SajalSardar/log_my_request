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
     */
    public function save(CategoryService $service)
    {
        $this->form->validate();
        $isCreate = $service->store($this->form);
        $isUpload = $this->form->image ?  Fileupload::upload($this->form, $isCreate->getKey(), Category::class,  300,  300) : '';
        $response = $isCreate ? 'Data has been update successfuly' : 'Something went wrong';
        flash()->success($response);
        return redirect()->to('/dashboard/category');
    }

    public function render()
    {
        return view('livewire.category.create-category');
    }
}
