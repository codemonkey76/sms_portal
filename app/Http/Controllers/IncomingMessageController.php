<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomingMessageRequest;
use App\Models\Customer;
use App\Models\Message;
use Illuminate\Validation\ValidationException;

class IncomingMessageController extends Controller
{
    public function store(IncomingMessageRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['is_mms'] = (bool) preg_match("(https://clicksend-api-downloads.s3[^'\"]*)", $validated['body']);
            Message::create([
                'customer_id' => optional(Customer::where('senderId', $validated['to'])->first())->id ?? 1,
                'user_id' => null,
                'body' => $validated['body'],
                'numSegments' => 0,
                'from' => $validated['sms'],
                'to' => $validated['to'],
                'status' => 'Received',
                'sid' => $validated['message_id'],
                'isMMS' => $validated['is_mms'],
                'dateUpdated' => now(),
                'dateSent' => now(),
                'dateCreated' => now(),
            ]);
        } catch (ValidationException $ex) {
            info(json_encode($ex->errors()));
        }

        return response('OK', 200);
    }
}
