<?php

namespace App\Http\Livewire\Messages;

use App\Http\Livewire\Traits\WithSearch;
use App\Models\Message;
use Livewire\Component;

class Index extends Component
{
    use WithSearch;
    public $archived;
    public function mount($archived = false) {
        $this->archived = $archived;
    }
    public function getRowsQueryProperty()
    {
        return Message::query()
            ->where('customer_id', auth()->user()->current_customer_id)
            ->whereIsArchived($this->archived)
            ->orderBy('dateCreated', 'DESC')
            ->search($this->search);
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }
    public function render()
    {

        return view('livewire.messages.index', ['messages' => $this->rows]);
    }

    public function archiveMessage(int $messageId): void
    {
        $message = Message::findOrFail($messageId);
        $message->archive();
        $this->notify('Message archived successfully!');
    }
}
