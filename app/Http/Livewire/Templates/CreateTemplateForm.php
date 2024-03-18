<?php

namespace App\Http\Livewire\Templates;

use App\Models\Template;
use Livewire\Component;

class CreateTemplateForm extends Component
{
    public string $description = '';

    public string $content = '';

    protected $rules = [
        'description' => 'required',
        'content' => 'required',
    ];

    public function render()
    {
        return view('livewire.templates.create-template-form');
    }

    public function createTemplate()
    {
        $this->validate();

        $data = [
            'description' => $this->description,
            'content' => $this->content,
            'customer_id' => auth()->user()->currentCustomer->id,
        ];

        Template::create($data);

        return redirect()->route('templates.index');
    }

    public function back()
    {
        return redirect()->route('templates.index');
    }
}
