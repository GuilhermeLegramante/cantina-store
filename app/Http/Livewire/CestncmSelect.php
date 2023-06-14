<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithSelect;
use Livewire\Component;

class CestncmSelect extends Component
{
    use WithSelect;

    public $title = 'CEST/NCM';
    public $modalId = 'modal-select-cestncm';
    public $searchFieldsLabel = 'Código ou Descrição';

    public $closeModal = 'closeCestncmModal';
    public $selectModal = 'selectCestncm';
    public $showModal = 'showCestncmModal';

    protected $repositoryClass = 'App\Repositories\CestncmRepository';

    public function render()
    {
        $this->insertButtonOnSelectModal = true;

        $this->addMethod = 'showCestncmFormModal';

        $this->search();

        $data = $this->data;

        return view('livewire.cestncm-select', compact('data'));
    }
}
