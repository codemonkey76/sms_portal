<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $user->load('allCustomers');

        return view('users.edit', compact('user'));
    }
}
