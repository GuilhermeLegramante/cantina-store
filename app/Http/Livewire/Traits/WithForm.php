<?php

namespace App\Http\Livewire\Traits;

use App\Services\Mask;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

trait WithForm
{
    public $isEdition;
    public $recordId;

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    public function showModalDelete()
    {
        $this->emit('delete');
    }

    public function cleanFields($fields)
    {
        if (strpos($fields, ',') !== false) {
            $fields = explode(',', $fields);
        }
        $this->reset($fields);
    }

    public function store()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $this->customValidate();

            $repository = App::make($this->repositoryClass);

            $data = [];
            $array = json_decode(json_encode($this), true);
            foreach ($this->inputs as $value) {
                if (isset($value['type'])) {
                    if ($value['type'] == 'monetary') {
                        $data[$value['field']] = Mask::removeMoneyMask($array[$value['field']]);
                    }
                    if ($value['type'] == 'string') {
                        $data[$value['field']] = Mask::normalizeString($array[$value['field']]);
                    }
                    if ($value['type'] == 'number') {
                        $data[$value['field']] = $array[$value['field']];
                    }
                } else {
                    $data[$value['field']] = $array[$value['field']];
                }
            }
            $repository->save($data);
            session()->flash('success', 'Registro salvo com sucesso');
            DB::commit();

            return redirect()->route($this->entity . '.table');
        } catch (\Exception $error) {
            DB::rollback();

            session()->flash('error-details', $error->getMessage());

            isset($error->errorInfo) && $error->errorInfo[0] == '23000' ? session()->flash('error', config('messages.mysql.' . $error->errorInfo[1])) :
            session()->flash('error', $error->getMessage());
        }
    }

    public function update()
    {
        $this->validate();
        try {
            DB::beginTransaction();

            $this->customValidate();

            $repository = App::make($this->repositoryClass);
            $data = [];
            $array = json_decode(json_encode($this), true);
            foreach ($this->inputs as $value) {
                if ($value['edit']) {
                    if (isset($value['type'])) {
                        if ($value['type'] == 'monetary') {
                            $data[$value['field']] = Mask::removeMoneyMask($array[$value['field']]);
                        }
                        if ($value['type'] == 'string') {
                            $data[$value['field']] = Mask::normalizeString($array[$value['field']]);
                        }
                        if ($value['type'] == 'number') {
                            $data[$value['field']] = $array[$value['field']];
                        }
                    } else {
                        $data[$value['field']] = $array[$value['field']];
                    }
                }
            }

            $repository->update($data);
            session()->flash('success', 'Registro editado com sucesso');
            DB::commit();

            return redirect()->route($this->entity . '.table');
        } catch (\Exception $error) {
            DB::rollback();

            session()->flash('error-details', $error->getMessage());

            isset($error->errorInfo) && $error->errorInfo[0] == '23000' ? session()->flash('error', config('messages.mysql.' . $error->errorInfo[1])) :
            session()->flash('error', $error->getMessage());
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();

            $this->customDeleteValidate();

            $repository = App::make($this->repositoryClass);
            $repository->delete([
                'recordId' => $this->recordId,
            ]);
            session()->flash('success', 'Registro excluído com sucesso');
            DB::commit();

            return redirect()->route($this->entity . '.table');
        } catch (\Exception $error) {
            DB::rollback();

            $this->emit('close');

            session()->flash('error-details', $error->getMessage());

            isset($error->errorInfo) && $error->errorInfo[0] == '23000' ? session()->flash('error', config('messages.mysql.' . $error->errorInfo[1])) :
            session()->flash('error', $error->getMessage());
        }
    }
}
