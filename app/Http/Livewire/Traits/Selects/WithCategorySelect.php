<?php

namespace App\Http\Livewire\Traits\Selects;

use Illuminate\Support\Facades\App;
use App\Repositories\CategoryRepository;


trait WithCategorySelect
{
    public $categoryId;

    public $categoryDescription;

    public function selectCategory($id)
    {
        $repository = App::make(CategoryRepository::class);

        $data = $repository->findById($id);

        $this->categoryId = $data->id;

        $this->categoryDescription = $data->description;

        $this->resetValidation('categoryId');
    }
}
