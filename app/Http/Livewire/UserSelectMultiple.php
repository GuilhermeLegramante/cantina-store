<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\Traits\WithSelect;

class UserSelectMultiple extends Component
{
    use WithSelect;

    public $title = 'USUÁRIOS';
    public $modalId = 'modal-select-multiple-user';
    public $searchFieldsLabel = 'Código ou Nome';

    public $closeModal = 'closeMultipleUserModal';
    public $selectModal = 'selectMultipleUser';
    public $showModal = 'showMultipleUserModal';

    protected $repositoryClass = 'App\Repositories\UserRepository';

    public function mount()
    {
        $this->headerColumns = [
            ['field' => null, 'label' => 'checkbox', 'css' => 'text-center w-10'],
            ['field' => 'name', 'label' => 'Descrição', 'css' => 'w-50'],
        ];

        $this->bodyColumns = [
            ['field' => 'id', 'label' => 'name', 'type' => 'checkbox', 'css' => 'text-center'],
            ['field' => 'name', 'type' => 'string', 'css' => 'pl-12px'],
        ];

        $this->type = 'multiple';
    }

    public function render()
    {
        $this->modalActionButtons = null;

        $this->search();

        $data = $this->data;

        return view('livewire.user-select-multiple', compact('data'));
    }
}
