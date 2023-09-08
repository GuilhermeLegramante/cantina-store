<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use Livewire\Component;

class TypeFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-file-export';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\TypeRepository';

    public $name;
    public $isLocked;

    protected $inputs = [
        ['field' => 'recordId', 'edit' => true],
        ['field' => 'name', 'edit' => true, 'type' => 'string'],
        ['field' => 'isLocked', 'edit' => false],
    ];

    protected $listeners = [
        'showTypeFormModal',
    ];

    protected $validationAttributes = [
        'name' => 'Descrição',
        'isLocked' => 'Bloqueado para Edição',
    ];

    public function rules()
    {
        return [
            'name' => ['required'],
            'isLocked' => ['required'],
        ];
    }

    public function showTypeFormModal($id = null)
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
        $this->formTitle = strtoupper('DADOS DO(A) Tipo de Saída');
        $this->entity = 'type';
        $this->pageTitle = 'Tipo de Saída';

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
        $this->isLocked = $data->isLocked;
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
        return view('livewire.type-form-modal');
    }
}
