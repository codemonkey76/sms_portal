<?php

namespace App\Http\Livewire\Users;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class AssignCustomerForm extends Component
{
    public User $user;
    public bool $add = false;
    public bool $remove = false;
    public string $selectedCustomer = '';
    public string $selectedAssignCustomer = '';

    public array $customers;
    public array $assignedCustomers;


    public function updatedSelectedCustomer($value)
    {
        $this->add = ($value !== '');
    }

    public function updatedSelectedAssignCustomer($value)
    {
        $this->remove = ($value !== '');
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        //info('Running render() function');
        $this->customers = Customer::whereNotIn('id', $this->user->allCustomers()->pluck('customers.id'))
            ->orderBy('name')
            ->get()
            ->groupBy(fn($customer) => $customer->name[0])
            ->toArray();
        //info('Customers:');
        //info(json_encode($this->customers));



        //$this->assignedCustomers = $this->user->allCustomers->toArray();

        $this->assignedCustomers = $this->user->fresh()->allCustomers->toArray();
        //info('Assigned Customers:');
        //info(json_encode($this->assignedCustomers));
        return view('livewire.users.assign-customer-form');
    }

    public function assignCustomer()
    {
        $this->user->attachCustomer($this->selectedCustomer);
        $this->selectedCustomer = '';
        $this->add = false;
    }

    public function unassignCustomer()
    {
        $this->user->detachCustomer($this->selectedAssignCustomer);
        $this->selectedAssignCustomer = '';
        $this->remove = false;
    }

    public function itemSelected($event)
    {
        $buttonState = $event['selected'] !== '';
        info('Button State: ' . ($buttonState ? 'true':'false'));

        if ($event['name'] === 'customers') {
            $this->selectedCustomer = data_get($event, 'selected', '');
            $this->add = $buttonState;
            return;
        }

        if ($event['name'] === 'assignedCustomers') {
            $this->selectedAssignCustomer = data_get($event, 'selected', '');
            $this->remove = $buttonState;
        }

    }
}
