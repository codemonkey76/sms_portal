<?php

namespace App\Http\Livewire\Templates;

use App\Models\Tag;
use App\Models\Template;
use Livewire\Component;

class EditTemplateForm extends Component
{
    public Template $template;
    public array $tags = [];
    public array $selected_tags = [];

    protected $rules = [
        'template.description' => 'required',
        'template.content' => 'required',
        'selected_tags' => 'array',
    ];

    public function mount(Template $template)
    {
        $customer = auth()->user()->currentCustomer;
        $this->tags = $customer->tags->pluck('name')->toArray();
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
        $customer = auth()->user()->currentCustomer;

        $this->template->save();

        $tags = $customer->tags()->whereIn('name', $this->selected_tags)->pluck('id')->toArray();
        $this->template->tags()->sync($tags);

        return redirect()->route('templates.index');
    }
}
