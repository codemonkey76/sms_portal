<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $contacts = new LengthAwarePaginator([], 0, 15);


        if (!is_null(auth()->user()->currentCustomer)) {
            $contacts = auth()->user()->currentCustomer->contacts()->latest()->paginate(15);
        }

        return view('contacts.index', [
            'contacts' => $contacts
        ]);
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index');
    }
}
