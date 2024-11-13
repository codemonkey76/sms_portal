<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        return view('tags.index');
    }

    public function create(): View
    {
        return view('tags.create');
    }
}
