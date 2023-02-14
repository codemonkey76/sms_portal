<?php

namespace App\Http\Livewire\Lists;

use App\Http\Livewire\Traits\WithSearch;
use App\Models\ContactList;
use Livewire\Component;

class Index extends Component
{
    use WithSearch;

    public function getRowsQueryProperty()
    {
        return ContactList::query()
            ->where('customer_id', auth()->user()->current_customer_id)
            ->search($this->search);
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }
    public function render()
    {
        return view('livewire.lists.index', ['lists' => $this->rows]);
    }
}
