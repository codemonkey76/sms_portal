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
        $messages = Message::paginate(15);

        return view('messages.index', compact('messages'));
    }
}
