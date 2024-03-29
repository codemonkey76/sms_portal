<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class EditUserForm extends Component
{
    public User $user;

    protected function rules(): array
    {
        return [
            'user.name' => 'required|string|max:50',
            'user.email' => 'required|email',
            'user.isAdmin' => 'required|boolean',
            'user.isActive' => 'required|boolean',
        ];
    }

    public function render()
    {
        return view('livewire.users.edit-user-form');
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function updatedUserName()
    {
        $this->validateOnly('user.name');
    }

    public function updatedUserEmail()
    {
        $this->validateOnly('user.email');
    }

    public function back()
    {
        return redirect()->route('users.index');
    }

    public function editUser()
    {
        $this->validate();

        $this->user->save();

        return redirect()->route('users.index');
    }
}
