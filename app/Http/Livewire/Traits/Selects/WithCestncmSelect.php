<?php

namespace App\Http\Livewire\Traits\Selects;

use App\Repositories\CestncmRepository;
use Illuminate\Support\Facades\App;
use Str;

trait WithCestncmSelect
{
    public $cestncmId;

    public $cestncmDescription;

    public function selectCestncm($id)
    {
        $repository = App::make(CestncmRepository::class);

        $data = $repository->findById($id);

        $this->cestncmId = $data->id;

        $this->cestncmDescription = Str::words($data->description, 10);

        $this->resetValidation('cestncmId');
    }
}
