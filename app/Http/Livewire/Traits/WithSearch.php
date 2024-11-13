<?php

namespace App\Http\Livewire\Traits;

trait WithSearch
{
    use WithPerPagePagination;

    public $search = '';

    public function updatedSearch()
    {
        \Log::info("Search updated to: $this->search");
        $this->resetPage();
    }
}
