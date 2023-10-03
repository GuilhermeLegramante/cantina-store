<?php

namespace App\Http\Livewire\Traits\Selects;

use Illuminate\Support\Facades\App;
use App\Repositories\ProductRepository;
use Str;

trait WithProductSelect
{
    public $productId;

    public $productDescription;

    public function selectProduct($id)
    {
        $repository = App::make(ProductRepository::class);

        $data = $repository->findById($id);

        $this->productId = $data->id;

        $this->productDescription = Str::words($data->description, 5);

        array_push($this->inputs,
            [
                'field' => 'productId',
                'edit' => true,
            ]
        );

        $this->resetValidation('productId');
    }
}
