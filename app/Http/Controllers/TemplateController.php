<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = new LengthAwarePaginator([], 0, 15);


        if (!is_null(auth()->user()->currentCustomer)) {
            $templates = auth()->user()->currentCustomer->templates()->orderBy('description')->paginate(15);
        }

        return view('templates.index', [
            'templates' => $templates,
        ]);
    }
    public function create()
    {
        return view('templates.create');
    }
    public function edit(Request $request, Template $template)
    {
        if (!Auth::user()->selectedCustomer($template->customer)) {
            abort(403);
        }
        return view('templates.edit', compact('template'));
    }
    public function update(Request $request, Template $template)
    {

    }
    public function destroy(Request $request, Template $template): RedirectResponse
    {
        if (!Auth::user()->selectedCustomer($template->customer)) {
            abort(403);
        }

        $template->delete();
        return redirect()->back();
    }
}
