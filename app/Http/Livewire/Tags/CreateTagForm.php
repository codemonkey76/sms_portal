<?php

namespace App\Http\Livewire\Tags;

use App\Models\Contact;
use App\Models\Tag;

use Livewire\Component;

class CreateTagForm extends Component
{
    public Tag $tag;

    protected function rules(): array
    {
        return [
            'tag.name' => 'required|string|max:255|unique:tags,name,NULL,id,customer_id,' .  auth()->user()->current_customer_id,
            'tag.retention_duration' => 'required|integer|min:1|max:50',
            'tag.retention_unit' => 'required|in:days,weeks,months,years',
            'tag.customer_id' => 'required|exists:customers,id'
        ];
    }

    public function createTag()
    {
        $this->validate();

        $this->tag->save();

        return redirect()->route('tags.index');
    }

    public function mount()
    {
        $this->tag = Tag::make(['customer_id' => auth()->user()->current_customer_id, 'retention_unit' => 'days']);
    }

    public function render()
    {
        return view('livewire.tags.create-tag-form');
    }

    public function back()
    {
        return redirect()->route('tags.index');
    }
}
