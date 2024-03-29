<?php

namespace App\Http\Controllers;

use App\Models\ContactList;
use Illuminate\Pagination\LengthAwarePaginator;

class ListController extends Controller
{
    public function index()
    {
        $lists = new LengthAwarePaginator([], 0, 15);

        if (! is_null(auth()->user()->currentCustomer)) {
            $lists = auth()->user()->currentCustomer->lists()->latest()->paginate(15);
        }

        return view('lists.index', [
            'lists' => $lists,
        ]);
    }

    public function create()
    {
        return view('lists.create');
    }

    public function edit(ContactList $list)
    {
        return view('lists.edit', compact('list'));
    }

    public function destroy(ContactList $list)
    {
        $list->contacts()->delete();
        $list->delete();

        return redirect()->route('lists.index');
    }
}
