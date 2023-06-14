<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithSelect;
use Livewire\Component;

class ManufacturerSelect extends Component
{
    use WithSelect;

    public $title = 'Fabricante';
    public $modalId = 'modal-select-manufacturer';
    public $searchFieldsLabel = 'Código ou Descrição';

    public $closeModal = 'closeManufacturerModal';
    public $selectModal = 'selectManufacturer';
    public $showModal = 'showManufacturerModal';

    protected $repositoryClass = 'App\Repositories\ManufacturerRepository';

    public function render()
    {
        $this->insertButtonOnSelectModal = true;

        $this->addMethod = 'showManufacturerFormModal';

        $this->search();

        $data = $this->data;

        return view('livewire.manufacturer-select', compact('data'));
    }
}
