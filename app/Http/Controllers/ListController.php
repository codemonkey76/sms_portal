<?php

namespace App\Http\Controllers;

use App\Models\ContactList;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ListController extends Controller
{
    public function index()
    {
        $lists = new LengthAwarePaginator([], 0, 15);


        if (!is_null(auth()->user()->currentCustomer)) {
            $lists = auth()->user()->currentCustomer->lists()->latest()->paginate(15);
        }

        return view('lists.index', [
            'lists' => $lists
        ]);
    }

    public function create()
    {
        return view('lists.create');
    }

    public function edit(ContactList $contactList)
    {
        return view('lists.edit', compact('contactList'));
    }
}
