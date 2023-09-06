<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Components\Button;
use App\Http\Livewire\Traits\WithDatatable;
use App\Services\SessionService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;

class ManufacturerTable extends Component
{
    use WithDatatable, WithPagination;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-building';
    public $searchFieldsLabel = 'Código ou Nome';
    public $hasForm = true;
    public $formModalEmitMethod = 'showManufacturerFormModal';
    public $formType = 'modal';

    public $headerColumns = [
        ['field' => 'id', 'label' => 'Código', 'css' => 'text-center w-10', 'visible' => 'true'],
        ['field' => 'name', 'label' => 'Nome', 'css' => 'w-80', 'visible' => 'true'],
        ['field' => null, 'label' => 'Ações', 'css' => 'text-center w-5', 'visible' => 'true'],
    ];

    public $bodyColumns = [
        ['field' => 'id', 'type' => 'string', 'css' => 'text-center', 'visible' => 'true', 'editable' => 'false'],
        ['field' => 'name', 'type' => 'string', 'css' => 'pl-12px', 'visible' => 'true', 'editable' => 'true'],
    ];

    protected $repositoryClass = 'App\Repositories\ManufacturerRepository';

    public function mount()
    {
        $this->entity = 'manufacturer';
        $this->pageTitle = 'Fabricante';

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

        return view('livewire.manufacturer-table', compact('data', 'buttons'));
    }
}
