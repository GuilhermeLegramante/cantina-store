<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithSelect;
use Livewire\Component;

class CfopSelect extends Component
{
    use WithSelect;

    public $title = 'CFOP';
    public $modalId = 'modal-select-cfop';
    public $searchFieldsLabel = 'Código ou Descrição';

    public $closeModal = 'closeCfopModal';
    public $selectModal = 'selectCfop';
    public $showModal = 'showCfopModal';

    protected $repositoryClass = 'App\Repositories\CfopRepository';

    public function render()
    {
        $this->insertButtonOnSelectModal = false;

        $this->addMethod = 'showCfopFormModal';

        $this->search();

        $data = $this->data;

        return view('livewire.cfop-select', compact('data'));
    }
}
