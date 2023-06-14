<?php

namespace App\Http\Livewire\Traits\Selects;

use Illuminate\Support\Facades\App;
use App\Repositories\MeasurementUnitRepository;


trait WithMeasurementUnitSelect
{
    public $measurementUnitId;

    public $measurementUnitDescription;

    public function selectMeasurementUnit($id)
    {
        $repository = App::make(MeasurementUnitRepository::class);

        $data = $repository->findById($id);

        $this->measurementUnitId = $data->id;

        $this->measurementUnitDescription = $data->description;

        $this->resetValidation('measurementUnitId');
    }
}
