<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithForm;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class UserForm extends Component
{
    use WithForm;

    public $entity = 'user';
    public $pageTitle = 'Usuário';
    public $icon = 'fas fa-user';
    public $basePath = 'user.table';
    public $previousRoute = 'user.table';
    public $method = 'store';
    public $formTitle = 'DADOS DO USUÁRIO';

    protected $repositoryClass = 'App\Repositories\UserRepository';

    public $name;
    public $login;
    public $password;
    public $password_confirmation;
    public $email;
    public $isAdmin;

    protected $inputs = [
        ['field' => 'recordId', 'edit' => true],
        ['field' => 'name', 'edit' => true, 'type' => 'string'],
        ['field' => 'login', 'edit' => true, 'type' => 'string'],
        ['field' => 'password', 'edit' => true, 'type' => 'string'],
        ['field' => 'email', 'edit' => true],
        ['field' => 'isAdmin', 'edit' => true],
    ];

    protected $validationAttributes = [
        'name' => 'Nome',
        'login' => 'Login',
        'password' => 'Senha',
        'email' => 'E-mail',
        'isAdmin' => 'Admin',
    ];

    public function rules()
    {
        return [
            'name' => ['required'],
            'login' => ['required'],
            'password' => ['required', 'confirmed'],
            'isAdmin' => ['required'],
            'email' => ['email', 'nullable'],
        ];
    }

    public function mount($id = null)
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

            $this->reset('recordId', 'name', 'login', 'password', 'password_confirmation', 'email', 'isAdmin');
        }
    }

    public function setFields($data)
    {
        $this->recordId = $data->id;

        $this->name = $data->name;

        $this->login = $data->login;

        $this->isAdmin = $data->isAdmin;

        $this->email = $data->email;
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
        return view('livewire.user-form');
    }
}
