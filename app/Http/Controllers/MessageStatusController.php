<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageStatusController extends Controller
{
    public function store(Request $request)
    {
        $message = Message::where('sid', $request->message_id)->first();
        if (is_null($message)) {
            info('Message was not found in the database');
            return;
        }
        $message->update([
            'status' => $request->status,
            'dateUpdated' => now(),
            'dateSent' => ($request->status==='Delivered')?now():null
        ]);
    }
}
