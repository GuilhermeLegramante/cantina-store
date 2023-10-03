<?php

namespace App\Http\Livewire\Traits\Selects;

use Illuminate\Support\Facades\App;
use App\Repositories\StoreRepository;
use Str;

trait WithStoreSelect
{
    public $storeId;

    public $storeDescription;

    public function selectStore($id)
    {
        $repository = App::make(StoreRepository::class);

        $data = $repository->findById($id);

        $this->storeId = $data->id;

        $this->storeDescription = Str::words($data->description, 5);

        array_push($this->inputs,
            [
                'field' => 'storeId',
                'edit' => true,
            ]
        );

        $this->resetValidation('storeId');
    }
}
