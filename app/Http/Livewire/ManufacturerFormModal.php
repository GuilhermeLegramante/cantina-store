<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use Livewire\Component;

class ManufacturerFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-building';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\ManufacturerRepository';

    public $name;

    protected $inputs = [
        ['field' => 'recordId', 'edit' => true],
        ['field' => 'name', 'edit' => true, 'type' => 'string'],
    ];

    protected $listeners = [
        'showManufacturerFormModal',
    ];

    protected $validationAttributes = [
        'name' => 'Nome',
    ];

    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }

    public function showManufacturerFormModal($id = null)
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
        $this->formTitle = strtoupper('DADOS DO(A) ' . 'Fabricante');
        $this->entity = 'manufacturer';
        $this->pageTitle = 'Fabricante';

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

        $this->name = $data->name;
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
        return view('livewire.manufacturer-form-modal');
    }
}
