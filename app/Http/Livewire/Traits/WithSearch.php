<?php

namespace App\Http\Livewire\Traits;

trait WithSearch
{
    use WithPerPagePagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }
}
