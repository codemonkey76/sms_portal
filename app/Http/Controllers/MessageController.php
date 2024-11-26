<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function create(): View
    {
        return view('messages.create');
    }

    public function index(Request $request): View
    {
        return view('messages.index', [ 'archived' => false ]);
    }

    public function show(Request $request, Message $message)
    {
        if (! $request->user()->selectedCustomer($message->customer)) {
            abort(403);
        }

        return view('messages.show', [
            'message' => $message,
            'archived' => false,
        ]);
    }

    public function update(Request $request, Message $message)
    {
        if ($message->is_archived) {
            $message->unarchive();
        } else {
            $message->archive();
        }

        return redirect()->back();
    }
}
