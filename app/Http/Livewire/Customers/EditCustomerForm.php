<?php

namespace App\Http\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class EditCustomerForm extends Component
{

    public Customer $customer;

    protected function rules(): array
    {
        return [
            'customer.name'     => 'required|max:40|unique:customers,name,'.$this->customer->id,
            'customer.senderId' => 'required|max:20'
        ];
    }
    public function render()
    {
        return view('livewire.customers.edit-customer-form');
    }
    public function mount(Customer $customer)
    {
        $this->customer = $customer;
    }
    public function back()
    {
        return redirect()->route('customers.index');
    }
    public function updatedCustomerName()
    {
        $this->validateOnly('customer.name');
    }
    public function updatedCustomerSenderId()
    {
        $this->validateOnly('customer.senderId');
    }
    public function editCustomer()
    {
        $this->validate();

        $this->customer->save();

        return redirect()->route('customers.index');

    }
}
