<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Components\Button;
use App\Http\Livewire\Traits\WithDatatable;
use App\Services\SessionService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;

class CsosnTable extends Component
{
    use WithDatatable, WithPagination;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-list';
    public $searchFieldsLabel = 'Código ou Descrição';
    public $hasForm = true;
    public $formModalEmitMethod = 'showCsosnFormModal';
    public $formType = 'modal';

    public $headerColumns = [
        ['field' => 'id', 'label' => 'Id', 'css' => 'text-center w-10', 'visible' => 'true'],
        ['field' => 'code', 'label' => 'Código', 'css' => 'text-center w-10', 'visible' => 'true'],
        ['field' => 'description', 'label' => 'Descrição', 'css' => 'w-80', 'visible' => 'true'],
        ['field' => null, 'label' => 'Ações', 'css' => 'text-center w-5', 'visible' => 'true'],
    ];

    public $bodyColumns = [
        ['field' => 'id', 'type' => 'string', 'css' => 'text-center', 'visible' => 'true', 'editable' => 'false'],
        ['field' => 'code', 'type' => 'string', 'css' => 'text-center', 'visible' => 'true', 'editable' => 'true'],
        ['field' => 'description', 'type' => 'string', 'css' => 'pl-12px', 'visible' => 'true', 'editable' => 'true'],
    ];

    protected $repositoryClass = 'App\Repositories\CsosnRepository';

    public function mount()
    {
        $this->entity = 'csosn';
        $this->pageTitle = 'CSOSN';

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

        return view('livewire.csosn-table', compact('data', 'buttons'));
    }
}
