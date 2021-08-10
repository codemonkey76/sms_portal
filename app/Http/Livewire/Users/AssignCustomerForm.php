<?php

namespace App\Http\Livewire\Users;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class AssignCustomerForm extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $customers = Customer::all()->groupBy(fn($c) => $c->name[0]);
        $assignedCustomers = $this->user->customers;

        return view('livewire.users.assign-customer-form', compact('customers', 'assignedCustomers'));
    }

    public function assignCustomer()
    {

    }
}
