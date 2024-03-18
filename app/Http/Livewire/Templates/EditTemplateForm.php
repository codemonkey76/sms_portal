<?php

namespace App\Http\Livewire\Templates;

use App\Models\Template;
use Livewire\Component;

class EditTemplateForm extends Component
{
    public Template $template;

    protected $rules = [
        'template.description' => 'required',
        'template.content' => 'required',
    ];

    public function mount(Template $template)
    {
        $this->template = $template;
    }

    public function back()
    {
        return redirect()->route('templates.index');
    }

    public function render()
    {
        return view('livewire.templates.edit-template-form');
    }

    public function updateTemplate()
    {
        $this->validate();

        $this->template->save();

        return redirect()->route('templates.index');
    }
}
