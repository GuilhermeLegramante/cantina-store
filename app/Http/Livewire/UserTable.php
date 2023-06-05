<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use App\Http\Livewire\Components\Button;
use App\Http\Livewire\Traits\WithDatatable;
use Livewire\Component;
use App\Services\SessionService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;


class UserTable extends Component
{
    use WithDatatable, WithPagination;

    public $entity = 'user';
    public $pageTitle = 'Usuário';
    public $icon = 'fas fa-user';
    public $searchFieldsLabel = 'Código ou Nome';
    public $hasForm = true;

    public $headerColumns = [
        ['field' => 'id', 'label' => 'Código', 'css' => 'text-center w-15'],
        ['field' => 'name', 'label' => 'Nome', 'css' => 'w-70'],
        ['field' => 'isAdmin', 'label' => 'Administrador', 'css' => 'text-center w-15'],
        ['field' => null, 'label' => 'Ações', 'css' => 'text-center'],
    ];

    public $bodyColumns = [
        ['field' => 'id', 'type' => 'string', 'css' => 'text-center'],
        ['field' => 'name', 'type' => 'string', 'css' => 'pl-12px'],
        ['field' => 'isAdmin', 'type' => 'boolean', 'css' => 'text-center'],
    ];

    protected $repositoryClass = 'App\Repositories\UserRepository';

    public function mount()
    {
        SessionService::start();
    }

    public function rowButtons(): array
    {
        return [
            Button::create('Selecionar')
                ->method('showForm')
                ->class('btn-primary')
                ->icon('fas fa-search'),
        ];
    }

    public function render()
    {
        $repository = App::make($this->repositoryClass);

        $data = $repository->all($this->search, $this->sortBy, $this->sortDirection, $this->perPage);

        if ($data->total() == $data->lastItem()) {
            $this->emit('scrollTop');
        }

        $buttons = $this->rowButtons();

        return view('livewire.user-table', compact('data', 'buttons'));
    }
}
