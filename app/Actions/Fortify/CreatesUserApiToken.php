<?php

namespace App\Actions\Fortify;

use App\Contracts\CreatesUserApiTokens;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreatesUserApiToken implements CreatesUserApiTokens
{
    public function create(User $user, array $input): string
    {
        Validator::make($input, [
            'email' => ['required', 'string', 'email'],
            'current_password' => ['required', 'string'],
            'device_name' => ['required', 'string', 'max:80'],
        ])->after(function ($validator) use ($user, $input) {
            if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        })->validateWithBag('apiTokens');

        return $user->createToken($input['device_name'])->plainTextToken;
    }
}
