<?php

namespace App\Http\Livewire\Tags;

use App\Http\Livewire\Traits\WithSearch;
use App\Models\Tag;
use Livewire\Component;

class Index extends Component
{
    use WithSearch;
    public $deleting = null;

    public $showDeleteModal = false;

    protected $listeners = ['refreshTags' => '$refresh'];

    public function getRowsQueryProperty()
    {
        return Tag::query()
            ->where('customer_id', auth()->user()->current_customer_id)
            ->search($this->search);
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }

    public function render()
    {
        return view('livewire.tags.index', ['tags' => $this->rows]);
    }

    public function delete(Tag $tag)
    {
        $this->deleting = $tag;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->deleting = null;
        $this->showDeleteModal = false;
    }

    public function confirmDelete()
    {
        if ($this->deleting) {
            $this->deleting->delete();
        }

        $this->showDeleteModal = false;

        $this->notify('Tag deleted successfully!');
    }
}
