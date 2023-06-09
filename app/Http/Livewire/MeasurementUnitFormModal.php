<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use Livewire\Component;

class MeasurementUnitFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-list';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\MeasurementUnitRepository';

    public $description;
    public $acronym;

    protected $inputs = [
        ['field' => 'recordId', 'edit' => true],
        ['field' => 'description', 'edit' => true, 'type' => 'string'],
        ['field' => 'acronym', 'edit' => true, 'type' => 'string'],

    ];

    protected $listeners = [
        'showMeasurementUnitFormModal',
    ];

    protected $validationAttributes = [
        'description' => 'Descrição',
        'acronym' => 'Abreviatura',
    ];

    public function rules()
    {
        return [
            'description' => ['required'],
        ];
    }

    public function showMeasurementUnitFormModal($id = null)
    {
        if (isset($id)) {
            $this->method = 'update';

            $this->isEdition = true;

            $repository = App::make($this->repositoryClass);

            $data = $repository->findById($id);

            if (isset($data)) {
                $this->setFields($data);
            }
        }
    }

    public function mount($id = null)
    {
        $this->formTitle = strtoupper('DADOS DO(A) ' . 'Unidade de Medida');
        $this->entity = 'measurementUnit';
        $this->pageTitle = 'Unidade de Medida';

        if (isset($id)) {
            $this->method = 'update';

            $this->isEdition = true;

            $repository = App::make($this->repositoryClass);

            $data = $repository->findById($id);

            if (isset($data)) {
                $this->setFields($data);
            }
        }
    }

    public function setFields($data)
    {
        $this->recordId = $data->id;

        $this->description = $data->description;

        $this->acronym = $data->acronym;

    }

    public function customValidate()
    {
        return true;
    }

    public function customDeleteValidate()
    {
        return true;
    }

    public function render()
    {
        return view('livewire.measurement-unit-form-modal');
    }
}
