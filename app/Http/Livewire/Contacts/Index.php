<?php

namespace App\Http\Livewire\Contacts;

use App\Http\Livewire\Traits\WithSearch;
use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    use WithSearch;

    public $deleting = null;
    public $showDeleteModal = false;

    protected $listeners = ['refreshContacts' => '$refresh'];

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

    public function getHasListsProperty()
    {
        return auth()->user()->currentCustomer->lists->count() > 0;
    }

    public function delete(Contact $contact)
    {
        $this->deleting = $contact;
        $this->showDeleteModal = true;
    }
    public function cancelDelete()
    {
        $this->deleting = null;
        $this->showDeleteModal = false;
    }
    public function confirmDelete()
    {
        if ($this->deleting)
            $this->deleting->delete();

        $this->showDeleteModal = false;

        $this->notify('Contact deleted successfully!');
    }

}
