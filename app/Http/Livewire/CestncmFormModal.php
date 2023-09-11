<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use Livewire\Component;

class CestncmFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-list';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\CestncmRepository';

    public $cest;
    public $ncm;
    public $description;

    protected $inputs = [
        ['field' => 'recordId', 'edit' => true],
        ['field' => 'cest', 'edit' => true, 'type' => 'string'],
        ['field' => 'ncm', 'edit' => true, 'type' => 'string'],
        ['field' => 'description', 'edit' => true, 'type' => 'string'],
    ];

    protected $listeners = [
        'showCestncmFormModal',
    ];

    protected $validationAttributes = [
        'cest' => 'CEST',
        'ncm' => 'NCM',
        'description' => 'Descrição',
    ];

    public function rules()
    {
        return [
            'cest' => ['required'],
            'ncm' => ['required'],
            'description' => ['required'],
        ];
    }

    public function showCestncmFormModal($id = null)
    {
        if (isset($id)) {
            $this->method = 'update';

            $this->isEdition = true;

            $repository = App::make($this->repositoryClass);

            $data = $repository->findById($id);

            if (isset($data)) {
                $this->setFields($data);
            }
        } else {
            $this->isEdition = false;

            $this->reset('recordId', 'cest', 'ncm', 'description');
        }
    }

    public function mount($id = null)
    {
        $this->formTitle = strtoupper('DADOS DO(A) ' . 'CEST/NCM');
        $this->entity = 'cestncm';
        $this->pageTitle = 'CEST/NCM';

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

        $this->cest = $data->cest;

        $this->ncm = $data->ncm;

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
        return view('livewire.cestncm-form-modal');
    }
}
