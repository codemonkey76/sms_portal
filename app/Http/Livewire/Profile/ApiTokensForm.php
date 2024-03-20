<?php

namespace App\Http\Livewire\Profile;

use App\Contracts\CreatesUserApiTokens;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Livewire\Component;

class ApiTokensForm extends Component
{
    public $state = [
        'current_email' => '',
        'current_password' => '',
        'device_name' => '',
    ];

    public function deleteToken(PersonalAccessToken $token)
    {
        $token->delete();

        $this->notify('Token deleted successfully!');
    }

    public function createApiToken(CreatesUserApiTokens $tokenCreator): void
    {
        $this->resetErrorBag();

        $token = $tokenCreator->create(Auth::user(), $this->state);

        $this->state = [
            'current_email' => '',
            'current_password' => '',
            'device_name' => '',
        ];

        $this->emit('createToken', $token);
    }

    public function render()
    {
        return view('livewire.profile.api-tokens-form');
    }
}
