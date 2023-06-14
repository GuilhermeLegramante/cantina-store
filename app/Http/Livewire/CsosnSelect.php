<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithSelect;
use Livewire\Component;

class CsosnSelect extends Component
{
    use WithSelect;

    public $title = 'CSOSN';
    public $modalId = 'modal-select-csosn';
    public $searchFieldsLabel = 'Código ou Descrição';

    public $closeModal = 'closeCsosnModal';
    public $selectModal = 'selectCsosn';
    public $showModal = 'showCsosnModal';

    protected $repositoryClass = 'App\Repositories\CsosnRepository';

    public function render()
    {
        $this->insertButtonOnSelectModal = false;

        $this->addMethod = 'showCsosnFormModal';

        $this->search();

        $data = $this->data;

        return view('livewire.csosn-select', compact('data'));
    }
}
