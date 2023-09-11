<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\WithForm;
use App\Services\Mask;
use Livewire\Component;

class StoreFormModal extends Component
{
    use WithForm;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-store';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\StoreRepository';

    public $name;
    public $document;

    protected $inputs = [
        ['field' => 'recordId', 'edit' => true],
        ['field' => 'name', 'edit' => true, 'type' => 'string'],
        ['field' => 'document', 'edit' => true, 'type' => 'string'],
    ];

    protected $listeners = [
        'showStoreFormModal',
    ];

    protected $validationAttributes = [
        'name' => 'Nome',
        'document' => 'Documento',
    ];

    public function rules()
    {
        return [
            'name' => ['required'],
            'document' => ['required'],
        ];
    }

    public function showStoreFormModal($id = null)
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

            $this->reset('recordId', 'name', 'document');
        }
    }

    public function mount($id = null)
    {
        $this->formTitle = strtoupper('DADOS DO(A) Loja');
        $this->entity = 'store';
        $this->pageTitle = 'Loja';

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
        return view('livewire.store-form-modal');
    }
}
