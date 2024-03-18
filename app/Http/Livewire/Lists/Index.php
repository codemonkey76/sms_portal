<?php

namespace App\Http\Livewire\Lists;

use App\Http\Livewire\Traits\WithSearch;
use App\Models\ContactList;
use Livewire\Component;

class Index extends Component
{
    use WithSearch;

    public $deleting = null;

    public $showDeleteModal = false;

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

    public function delete(ContactList $list)
    {
        $this->deleting = $list;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->deleting = null;
        $this->showDeleteModal = false;
    }

    public function confirmDelete()
    {
        if ($this->deleting) {
            $this->deleting->delete();
        }

        $this->showDeleteModal = false;

        $this->notify('List deleted successfully!');
    }
}
