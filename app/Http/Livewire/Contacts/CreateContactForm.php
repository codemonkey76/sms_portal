<?php

namespace App\Http\Livewire\Contacts;

use App\Models\Contact;
use App\Models\Customer;
use Livewire\Component;

class CreateContactForm extends Component
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
            'contact.customer_id' => ''
        ];
    }

    public function createContact()
    {
        $this->validate();
        $this->contact->save();

        return redirect()->route('contacts.index');
    }

    public function mount()
    {
        $this->lists = auth()->user()->currentCustomer->lists;

        $this->contact = Contact::make([
            'customer_id' => auth()->user()->current_customer_id,
            'contact_list_id' => $this->lists->first()->id
        ]);
    }
    public function render()
    {
        return view('livewire.contacts.create-contact-form');
    }
}
