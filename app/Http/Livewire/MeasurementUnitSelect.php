<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithSelect;
use Livewire\Component;

class MeasurementUnitSelect extends Component
{
    use WithSelect;

    public $title = 'Unidade de Medida';
    public $modalId = 'modal-select-measurementUnit';
    public $searchFieldsLabel = 'Código ou Descrição';

    public $closeModal = 'closeMeasurementUnitModal';
    public $selectModal = 'selectMeasurementUnit';
    public $showModal = 'showMeasurementUnitModal';

    protected $repositoryClass = 'App\Repositories\MeasurementUnitRepository';

    public function render()
    {
        $this->insertButtonOnSelectModal = true;

        $this->addMethod = 'showMeasurementUnitFormModal';

        $this->search();

        $data = $this->data;

        return view('livewire.measurement-unit-select', compact('data'));
    }
}
