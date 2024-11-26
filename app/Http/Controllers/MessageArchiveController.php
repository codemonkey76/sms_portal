<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class MessageArchiveController extends Controller
{
    public function store(Request $request, Message $message)
    {
        if ($request->user()->isCurrentCustomer($message->customer)) {
            $message->archive();
        }

        return redirect()->back();
    }

    public function destroy(Request $request, Message $message, $archive)
    {
        if ($request->user()->isCurrentCustomer($message->customer)) {
            $message->unarchive();
        }

        return redirect()->back();
    }

    public function index(Request $request): View
    {

        return view('messages.index', [
            'archived' => true,
        ]);
    }
}
