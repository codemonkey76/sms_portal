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

    protected $listeners = ['itemSelected' => 'itemSelected'];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $this->customers = Customer::whereNotIn('id', $this->user->allCustomers()->pluck('customers.id'))
            ->orderBy('name')
            ->get()
            ->groupBy(fn($customer) => $customer->name[0])
            ->toArray();

        $this->assignedCustomers = $this->user->allCustomers->toArray();
        return view('livewire.users.assign-customer-form', ['customers' => $this->customers,
            'assignedCustomers' => $this->assignedCustomers]);
    }

    public function assignCustomer()
    {
        $this->user->allCustomers()->syncWithoutDetaching($this->selectedCustomer);
    }

    public function unassignCustomer()
    {
        $this->user->allCustomers()->detach($this->selectedAssignCustomer);
    }

    public function itemSelected($event)
    {
        $buttonState = $event['selected'] !== '';
        info('Button State: ' . ($buttonState ? 'true':'false'));

        if ($event['name'] === 'customers') {
            $this->selectedCustomer = $buttonState ? $event['selected'] : '';
            $this->add = $buttonState;
            return;
        }

        if ($event['name'] === 'assignedCustomers') {
            $this->selectedAssignCustomer = $buttonState ? $event['selected'] : '';
            $this->remove = $buttonState;
        }

    }
}
