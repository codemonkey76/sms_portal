<?php

namespace App\Http\Livewire\Contacts;

use App\Models\Contact;
use Livewire\Component;

class EditContactForm extends Component
{
    public Contact $contact;

    public $lists;

    protected function rules(): array
    {
        return [
            'contact.number' => '',
            'contact.first_name' => '',
            'contact.last_name' => '',
            'contact.company_name' => '',
            'contact.contact_list_id' => '',
        ];
    }

    public function mount(Contact $contact)
    {
        $this->contact = $contact;
        $this->lists = auth()->user()->currentCustomer->lists;
    }

    public function back()
    {
        return redirect()->route('contacts.index');
    }

    public function editContact()
    {
        $this->validate();

        $this->contact->save();

        return redirect()->route('contacts.index');

    }

    public function render()
    {
        return view('livewire.contacts.edit-contact-form');
    }
}
