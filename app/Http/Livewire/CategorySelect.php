<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithSelect;
use Livewire\Component;

class CategorySelect extends Component
{
    use WithSelect;

    public $title = 'Categoria';
    public $modalId = 'modal-select-category';
    public $searchFieldsLabel = 'Código ou Descrição';

    public $closeModal = 'closeCategoryModal';
    public $selectModal = 'selectCategory';
    public $showModal = 'showCategoryModal';

    protected $repositoryClass = 'App\Repositories\CategoryRepository';

    public function render()
    {
        $this->insertButtonOnSelectModal = true;

        $this->addMethod = 'showCategoryFormModal';

        $this->search();

        $data = $this->data;

        return view('livewire.category-select', compact('data'));
    }
}
