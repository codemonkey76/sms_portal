<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class IncomingMessageController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
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
                'message_id' => 'required|string'
            ]);

            $validated['is_mms'] = (bool)preg_match("(https://clicksend-api-downloads.s3[^'\"]*)", $validated['body']);
            info($validated);

        } catch (ValidationException $ex) {
            info(json_encode($ex->errors()));
        }

        return response('OK', 200);
    }
}
