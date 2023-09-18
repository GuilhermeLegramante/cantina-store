<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use App\Services\Mask;
use Livewire\Component;

class CustomerFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-users';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\CustomerRepository';

    public $description;
    public $document;

    protected $inputs = [
        ['field' => 'recordId', 'edit' => true],
        ['field' => 'description', 'edit' => true, 'type' => 'string'],
        ['field' => 'document', 'edit' => true, 'type' => 'string'],

    ];

    protected $listeners = [
        'showCustomerFormModal',
    ];

    protected $validationAttributes = [
        'description' => 'Descrição',
        'document' => 'Documento',
    ];

    public function rules()
    {
        return [
            'description' => ['required'],
            'document' => ['required'],
        ];
    }

    public function showCustomerFormModal($id = null)
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

            $this->reset('recordId', 'description', 'document');
        }
    }

    public function mount($id = null)
    {
        $this->formTitle = strtoupper('DADOS DO(A) Cliente');
        $this->entity = 'customer';
        $this->pageTitle = 'Cliente';

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
        $this->document = $data->document;

    }

    public function updatedDocument()
    {
        $this->document = Mask::cpfCnpj($this->document);
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
        return view('livewire.customer-form-modal');
    }
}
