<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithSelect;
use Livewire\Component;

class ProductSelect extends Component
{
    use WithSelect;

    public $title = 'Produto';
    public $modalId = 'modal-select-product';
    public $searchFieldsLabel = 'Código ou Descrição';

    public $closeModal = 'closeProductModal';
    public $selectModal = 'selectProduct';
    public $showModal = 'showProductModal';

    protected $repositoryClass = 'App\Repositories\ProductRepository';

    public function render()
    {
        $this->insertButtonOnSelectModal = true;

        $this->addMethod = 'showProductFormModal';

        $this->search();

        $data = $this->data;

        return view('livewire.product-select', compact('data'));
    }
}
