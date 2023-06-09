<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use Livewire\Component;

class CsosnFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-list';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\CsosnRepository';

    public $code;

    public $description;

    protected $inputs = [
        ['field' => 'recordId', 'edit' => true],
        ['field' => 'code', 'edit' => true, 'type' => 'string'],
        ['field' => 'description', 'edit' => true, 'type' => 'string'],
    ];

    protected $listeners = [
        'showCsosnFormModal',
    ];

    protected $validationAttributes = [
        'code' => 'Código',
        'description' => 'Descrição',
    ];

    public function rules()
    {
        return [
            'code' => ['required'],
            'description' => ['required'],
        ];
    }

    public function showCsosnFormModal($id = null)
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
        $this->formTitle = strtoupper('DADOS DO(A) ' . 'CSOSN');
        $this->entity = 'csosn';
        $this->pageTitle = 'CSOSN';

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

        $this->code = $data->code;

        $this->description = $data->description;
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
        return view('livewire.csosn-form-modal');
    }
}
