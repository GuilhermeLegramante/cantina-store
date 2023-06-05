<?php

namespace App\Http\Livewire\Traits;

trait WithDatatable
{
    public $sortBy = 'id';
    public $sortDirection = 'asc';
    protected $paginationTheme = 'bootstrap';
    public $perPage = 30;
    public $searchDesc = '';
    public $searchCod = '';
    public $searchGeneric = '';
    public $search;
    public $hasForm = true;

    public function sortBy($field)
    {
        $this->sortDirection == 'asc' ? $this->sortDirection = 'desc' : $this->sortDirection = 'asc';
        return $this->sortBy = $field;
    }

    public function resetFields()
    {
        $this->searchGeneric = "";
        $this->searchCod = "";
        $this->searchDesc = "";
        $this->perPage = 30;
    }

    public function resetFieldsDynamicly($fields)
    {
        $this->reset($fields);
        $this->perPage = 30;
    }

    public function load($value)
    {
        if ($this->perPage >= 10) {
            $this->perPage += $value;

            $this->perPage == 0 ? $this->perPage = 30 : '';

            $this->perPage >= 0 ? $this->perPage = $this->perPage : $this->perPage = 30;
        }
    }

    public function showForm($id = null)
    {
        if (isset($id)) {
            return redirect()->route($this->entity . '.edit', ['id' => $id]);
        } else {

            return redirect()->route($this->entity . '.create');
        }
    }

    // Isso resolve o bug da busca em páginas > 1
    public function updatingSearch(): void
    {
        // Caso seja modal não há os links da paginação, por isso é necessário este teste
        // para evitar o erro "livewire gotopage doesnot exists"
        if(!isset($this->modalId)){
            $this->gotoPage(1);
        }
    }
}
