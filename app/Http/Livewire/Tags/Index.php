<?php

namespace App\Http\Livewire\Tags;

use App\Http\Livewire\Traits\WithSearch;
use App\Models\Contact;
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
        return view('livewire.tags.index', ['tags' => $this->rows]);
    }
}
