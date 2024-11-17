<?php

namespace App\Http\Livewire\Templates;

use App\Models\Template;
use Livewire\Component;

class CreateTemplateForm extends Component
{
    public string $description = '';

    public string $content = '';
    public array $tags = [];
    public array $selected_tags = [];

    protected $rules = [
        'selected_tags' => 'array',
        'description' => 'required',
        'content' => 'required',
    ];

    public function render()
    {
        return view('livewire.templates.create-template-form');
    }

    public function mount()
    {
        $customer = auth()->user()->currentCustomer;
        $this->tags = $customer->tags->pluck('name')->toArray();
    }

    public function createTemplate()
    {
        $this->validate();
        $customer = auth()->user()->currentCustomer;

        $data = [
            'description' => $this->description,
            'content' => $this->content,
            'customer_id' => $customer->id,
        ];

        $template = Template::create($data);
        $tags = $customer->tags()->whereIn('name', $this->selected_tags)->pluck('id')->toArray();
        $template->tags()->sync($tags);

        return redirect()->route('templates.index');
    }

    public function back()
    {
        return redirect()->route('templates.index');
    }
}
