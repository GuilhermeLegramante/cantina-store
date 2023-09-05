<?php

namespace App\Http\Livewire\Traits;

trait WithCustomDatatable
{
    public function showHideColumn($column)
    {
        foreach ($this->headerColumns as $key => $value) {
            if (isset($value['field']) && $value['field'] == $column) {
                $this->headerColumns[$key]['visible'] = !$value['visible'];
            }
        }

        foreach ($this->bodyColumns as $key => $value) {
            if (isset($value['field']) && $value['field'] == $column) {
                $this->bodyColumns[$key]['visible'] = !$value['visible'];
            }
        }
    }
}
