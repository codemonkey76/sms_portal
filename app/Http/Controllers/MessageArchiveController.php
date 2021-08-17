<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MessageArchiveController extends Controller
{
    public function store(Request $request, Message $message)
    {
        if (Auth::user()->isCurrentCustomer($message->customer)) {
            $message->archive();
        }
        return redirect()->back();
    }

    public function destroy(Request $request, Message $message, $archive)
    {
        if (Auth::user()->isCurrentCustomer($message->customer)) {
            $message->unarchive();
        }
        return redirect()->back();
    }

    public function index(): View
    {
        $messages = new LengthAwarePaginator([], 0, 15);


        if (!is_null(auth()->user()->currentCustomer)) {
            $messages = auth()->user()->currentCustomer->messages()->where('is_archived', true)->latest('dateCreated')->paginate(15);
        }

        return view('messages.index', [
            'messages' => $messages,
            'archived' => true
        ]);
    }
}
