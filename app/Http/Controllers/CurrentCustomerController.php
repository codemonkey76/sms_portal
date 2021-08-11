<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CurrentCustomerController extends Controller
{
    public function update(Request $request)
    {
        $customer = Customer::findOrFail($request->customer_id);

        $request->user()->switchCustomer($customer);

        return redirect(config('fortify.home'), 303);
    }
}
