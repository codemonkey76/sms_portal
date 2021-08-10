<?php

namespace App\View\Components\Controls;

use Illuminate\View\Component;

class Listbox extends Component
{
    public $selectedId = null;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.controls.listbox');
    }
}
