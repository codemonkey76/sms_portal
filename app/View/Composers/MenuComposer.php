<?php

namespace App\View\Composers;

use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view)
    {
        $view->with('customer_list', auth()->user()->customers);
    }
}
