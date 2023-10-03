<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Components\Button;
use App\Http\Livewire\Traits\WithDatatable;
use App\Services\SessionService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;

class StockTable extends Component
{
    use WithDatatable, WithPagination;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-cubes';
    public $searchFieldsLabel = 'Código ou Descrição';
    public $hasForm = true;
    public $formModalEmitMethod = 'showStockFormModal';
    public $formType = 'modal';

    public $headerColumns = [
        [
            'field' => 'code',
            'label' => 'Código',
            'css' => 'text-center w-10',
            'visible' => true,
        ],
        [
            'field' => 'barCode',
            'label' => 'Código de Barras',
            'css' => 'text-center w-10',
            'visible' => false,
        ],
        [
            'field' => 'description',
            'label' => 'Descrição',
            'css' => 'w-80',
            'visible' => true,
        ],
        [
            'field' => 'entryAmount',
            'label' => 'Total (Entrada)',
            'css' => 'text-center w-10',
            'visible' => false,
        ],
        [
            'field' => 'minEntryValue',
            'label' => 'Valor Mínimo (Entrada)',
            'css' => 'text-right w-10',
            'visible' => false,
        ],
        [
            'field' => 'maxEntryValue',
            'label' => 'Valor Máximo (Entrada)',
            'css' => 'text-right w-10',
            'visible' => false,
        ],
        [
            'field' => 'avgEntryValue',
            'label' => 'Valor Médio (Entrada)',
            'css' => 'text-right w-10',
            'visible' => false,
        ],
        [
            'field' => 'outputAmount',
            'label' => 'Total (Saída)',
            'css' => 'text-center w-10',
            'visible' => false,
        ],
        [
            'field' => 'minOutputValue',
            'label' => 'Valor Mínimo (Saída)',
            'css' => 'text-right w-10',
            'visible' => false,
        ],
        [
            'field' => 'maxOutputValue',
            'label' => 'Valor Máximo (Saída)',
            'css' => 'text-right w-10',
            'visible' => false,
        ],
        [
            'field' => 'avgOutputValue',
            'label' => 'Valor Médio (Saída)',
            'css' => 'text-right w-10',
            'visible' => false,
        ],
        [
            'field' => 'totalAvailable',
            'label' => 'Total Disponível',
            'css' => 'text-center w-10',
            'visible' => true,
        ],
        [
            'field' => null,
            'label' => 'Ações',
            'css' => 'text-center w-5',
            'visible' => true,
        ],
    ];

    public $bodyColumns = [
        [
            'field' => 'code',
            'type' => 'string',
            'css' => 'text-center',
            'visible' => true,
            'editable' => false,
        ],
        [
            'field' => 'barCode',
            'type' => 'string',
            'css' => 'text-center',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'description',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => true,
            'editable' => false,
        ],
        [
            'field' => 'entryAmount',
            'type' => 'string',
            'css' => 'text-center',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'minEntryValue',
            'type' => 'monetary',
            'css' => 'text-right',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'maxEntryValue',
            'type' => 'monetary',
            'css' => 'text-right',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'avgEntryValue',
            'type' => 'monetary',
            'css' => 'text-right',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'outputAmount',
            'type' => 'string',
            'css' => 'text-center',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'minOutputValue',
            'type' => 'monetary',
            'css' => 'text-right',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'maxOutputValue',
            'type' => 'monetary',
            'css' => 'text-right',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'avgOutputValue',
            'type' => 'monetary',
            'css' => 'text-right',
            'visible' => false,
            'editable' => false,
        ],
        [
            'field' => 'totalAvailable',
            'type' => 'string',
            'css' => 'text-center',
            'visible' => true,
            'editable' => false,
        ],
    ];

    protected $repositoryClass = 'App\Repositories\StockRepository';

    public function mount()
    {
        $this->entity = 'stock';
        $this->pageTitle = 'Estoque';

        SessionService::start();
    }

    public function rowButtons(): array
    {
        return [
            // Button::create('Selecionar')
            //     ->method('showForm')
            //     ->class('btn-primary')
            //     ->icon('fas fa-search'),
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

        return view('livewire.stock-table', compact('data', 'buttons'));
    }
}
