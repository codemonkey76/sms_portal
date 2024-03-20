<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomingMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'originalsenderid' => 'required|string',
            'body' => 'required|string',
            'message' => 'required|string',
            'sms' => 'required|string',
            'custom_string' => 'present',
            'to' => 'required|string',
            'original_message_id' => 'present',
            'originalmessageid' => 'present',
            'user_id' => 'required|string',
            'subaccount_id' => 'required|string',
            'original_body' => 'present',
            'timestamp' => 'required|numeric',
            'message_id' => 'required|string',
        ];
    }
}
