<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageStatsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer' => 'required|exists:customers,id',
            'monthsAgo' => 'required|integer|min:1|max:12',
        ];
    }
}
