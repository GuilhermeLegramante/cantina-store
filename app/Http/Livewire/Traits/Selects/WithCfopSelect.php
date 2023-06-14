<?php

namespace App\Http\Livewire\Traits\Selects;

use App\Repositories\CfopRepository;
use Illuminate\Support\Facades\App;
use Str;

trait WithCfopSelect
{
    public $cfopId;

    public $cfopDescription;

    public function selectCfop($id)
    {
        $repository = App::make(CfopRepository::class);

        $data = $repository->findById($id);

        $this->cfopId = $data->id;

        $this->cfopDescription = Str::words($data->description, 5);

        $this->resetValidation('cfopId');
    }
}
