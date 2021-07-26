<?php

namespace App\Http\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class CreateCustomerForm extends Component
{

    public $name;
    public $senderId;

    protected $rules = [
        'name' => 'required|max:40|unique:customers,name',
        'senderId' => 'required|max:20'
    ];
    public function back()
    {
        return redirect()->route('customers.index');
    }
    public function render()
    {
        return view('livewire.customers.create-customer-form');
    }

    public function updatedName()
    {
        $this->validateOnly('name');
    }
    public function updatedSenderId()
    {
        $this->validateOnly('senderId');
    }

    public function createCustomer()
    {
        $this->validate();
        Customer::create([
            'name' => $this->name,
            'senderId' => $this->senderId
        ]);

        return redirect()->route('customers.index');
    }
}
