<?php

namespace App\Http\Livewire\Traits\Selects;

use App\Repositories\ManufacturerRepository;
use Illuminate\Support\Facades\App;

trait WithManufacturerSelect
{
    public $manufacturerId;

    public $manufacturerDescription;

    public function selectManufacturer($id)
    {
        $repository = App::make(ManufacturerRepository::class);

        $data = $repository->findById($id);

        $this->manufacturerId = $data->id;

        $this->manufacturerDescription = $data->description;

        // $this->filter['manufacturer'] = $data->id;

        $this->resetValidation('manufacturerId');
    }
}
