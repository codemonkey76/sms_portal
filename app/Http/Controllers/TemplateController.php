<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = new LengthAwarePaginator([], 0, 15);


        if (!is_null($request->user()->currentCustomer)) {
            $templates = $request->user()->currentCustomer->templates()->orderBy('description')->paginate(15);
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
        if (!$request->user()->selectedCustomer($template->customer)) {
            abort(403);
        }
        return view('templates.edit', compact('template'));
    }

    public function update()
    {
    }
    public function destroy(Request $request, Template $template): RedirectResponse
    {
        if (!$request->user()->selectedCustomer($template->customer)) {
            abort(403);
        }

        $template->delete();
        return redirect()->back();
    }
}
