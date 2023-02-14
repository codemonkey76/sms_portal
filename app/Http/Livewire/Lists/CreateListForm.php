<?php

namespace App\Http\Livewire\Lists;

use App\Models\ContactList;
use Livewire\Component;

class CreateListForm extends Component
{
    public ContactList $list;

    protected function rules(): array
    {
        return [
            'list.name' => 'required',
            'list.customer_id' => 'required|exists:customers,id'
        ];
    }

    public function createList()
    {
        $this->validate();
        $this->list->save();

        return redirect()->route('lists.index');
    }

    public function back()
    {
        return redirect()->route('lists.index');
    }

    public function mount()
    {
        $this->list = ContactList::make(['customer_id' => auth()->user()->current_customer_id]);
    }

    public function render()
    {
        return view('livewire.lists.create-list-form');
    }
}
