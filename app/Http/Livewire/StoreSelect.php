<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithSelect;
use Livewire\Component;

class StoreSelect extends Component
{
    use WithSelect;

    public $title = 'Loja';
    public $modalId = 'modal-select-store';
    public $searchFieldsLabel = 'Código ou Descrição';

    public $closeModal = 'closeStoreModal';
    public $selectModal = 'selectStore';
    public $showModal = 'showStoreModal';

    protected $repositoryClass = 'App\Repositories\StoreRepository';

    public function render()
    {
        $this->insertButtonOnSelectModal = true;

        $this->addMethod = 'showStoreFormModal';

        $this->search();

        $data = $this->data;

        return view('livewire.store-select', compact('data'));
    }
}
