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
    public function index(): View
    {
        $messages = new LengthAwarePaginator([], 0, 15);


        if (!is_null(auth()->user()->currentCustomer)) {
            $messages = auth()->user()->currentCustomer->messages()->latest('dateCreated')->paginate(15);
        }

        return view('messages.index', compact('messages'));
    }
}
