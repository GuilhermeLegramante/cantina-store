<?php

namespace App\Http\Livewire\Traits\Selects;

use App\Repositories\CsosnRepository;
use Illuminate\Support\Facades\App;
use Str;

trait WithCsosnSelect
{
    public $csosnId;

    public $csosnDescription;

    public function selectCsosn($id)
    {
        $repository = App::make(CsosnRepository::class);

        $data = $repository->findById($id);

        $this->csosnId = $data->id;

        $this->csosnDescription = Str::words($data->description, 5);

        $this->resetValidation('csosnId');
    }
}
