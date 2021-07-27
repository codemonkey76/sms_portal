<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function create(): View
    {
        return view('messages.create');
    }
    public function index(): View
    {
        $messages = auth()->user()->customer->messages()->latest('dateCreated')->paginate(15);

        return view('messages.index', compact('messages'));
    }
}
