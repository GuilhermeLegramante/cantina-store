<?php

namespace App\Http\Livewire;

use App;
use App\Http\Livewire\Traits\Selects\WithProductSelect;
use App\Http\Livewire\Traits\Selects\WithStoreSelect;
use App\Http\Livewire\Traits\WithForm;
use App\Http\Livewire\Traits\WithTabs;
use App\Services\Mask;
use App\Services\Nfe\Invoice;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;
use Str;

class StockFormModal extends Component
{
    use WithForm, WithStoreSelect, WithProductSelect, WithTabs, WithFileUploads;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-cubes';
    public $method = 'store';
    public $formTitle;

    protected $repositoryClass = 'App\Repositories\StockRepository';

    public $products = [];
    public $value;
    public $quantity;
    public $nfe;

    public $totalItemsValue;

    public $inputs = [
        [
            'field' => 'recordId',
            'edit' => true,
        ],
        [
            'field' => 'storeId',
            'edit' => true,
        ],
        [
            'field' => 'products',
            'edit' => true,
        ],
    ];

    protected $listeners = [
        'showStockFormModal',
        'selectStore',
        'selectProduct',
    ];

    protected $validationAttributes = [
        'storeId' => 'Loja',
        'productId' => 'Produto',
        'value' => 'Valor',
        'quantity' => 'Quantidade',
        'products' => 'Produtos',
        'nfe' => 'Nota Fiscal',
    ];

    public function rules()
    {
        return [
            'storeId' => ['required'],
            'products' => ['required'],
            'nfe' => ['mimes:application/xml,xml', 'nullable'],
        ];
    }

    public function showStockFormModal($id = null)
    {
        $this->reset('recordId', 'storeId', 'products', 'nfe');

        $this->resetValidation();

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
        $this->formTitle = strtoupper('DADOS DO(A) Entrada no Estoque');
        $this->entity = 'stock';
        $this->pageTitle = 'Entrada no Estoque';

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

    }

    public function customValidate()
    {
        return true;
    }

    public function customDeleteValidate()
    {
        return true;
    }

    public function updatedValue()
    {
        $this->value = Mask::money($this->value);
    }

    public function addProduct()
    {
        $this->validate([
            'productId' => ['required'],
            'quantity' => ['numeric', 'min:1'],
            'value' => ['required'],
        ]);

        $product = [
            'id' => $this->productId,
            'description' => $this->productDescription,
            'quantity' => $this->quantity,
            'value' => $this->value,
        ];

        array_push($this->products, $product);

        $this->calcTotalItems();

        $this->reset('productId', 'productDescription', 'quantity', 'value');

        $this->resetValidation('productId', 'quantity', 'value');
    }

    public function deleteItem($key)
    {
        unset($this->products[$key]);
        $this->calcTotalItems();
    }

    public function calcTotalItems()
    {
        $this->totalItemsValue = 0;
        foreach ($this->products as $item) {
            $value = Mask::removeMoneyMask($item['value']);
            $this->totalItemsValue = $this->totalItemsValue + ($value * $item['quantity']);
        }

        $this->totalItemsValue = Mask::money($this->totalItemsValue);
    }

    public function updatedNfe()
    {
        $filename = Str::random(4) . '_' . $this->nfe->getClientOriginalName();

        $filePath = Storage::putFileAs('nfe', $this->nfe, $filename);

        $xml = Storage::get($filePath);

        $invoice = new Invoice($xml);

        Storage::delete($filePath);

        dd($invoice);

    }

    public function render()
    {
        return view('livewire.stock-form-modal');
    }
}
