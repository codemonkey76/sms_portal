<?php

namespace App\Http\Livewire\Lists;

use App\Models\ContactList;
use Livewire\Component;

class EditListForm extends Component
{
    public ContactList $list;

    protected function rules(): array
    {
        return [
            'list.name' => 'required',
            'list.customer_id' => 'required|exists:customers,id',
        ];
    }

    public function mount(ContactList $list)
    {
        $this->list = $list;
    }

    public function back()
    {
        return redirect()->route('lists.index');
    }

    public function editList()
    {
        $this->validate();

        $this->list->save();

        return redirect()->route('lists.index');

    }

    public function render()
    {
        return view('livewire.lists.edit-list-form');
    }
}
