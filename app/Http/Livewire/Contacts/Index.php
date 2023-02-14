<?php

namespace App\Http\Livewire\Contacts;

use App\Http\Livewire\Traits\WithSearch;
use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    use WithSearch;

    public function getRowsQueryProperty()
    {
        return Contact::query()
            ->where('customer_id', auth()->user()->current_customer_id)
            ->search($this->search);
    }
    
    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }

    public function render()
    {
        return view('livewire.contacts.index', ['contacts' => $this->rows]);
    }

}
