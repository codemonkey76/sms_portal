<?php

namespace App\Http\Livewire\Messages;

use App\Jobs\SendBulkMessage;
use App\Jobs\SendSingleMessage;
use App\Models\ContactList;
use App\Models\Tag;
use App\Models\Template;
use Livewire\Component;
use Livewire\WithPagination;
use Phlib\SmsLength\SmsLength;

class CreateMessageForm extends Component
{
    use WithPagination;

    public $templates;

    public $lists;

    public string $message = '';
    public array $tags = [];
    public array $selected_tags = [];

    public string $recipient = '';

    public string $message_type = 'single';

    public string $contactList = '';

    public ?string $selectedTemplate;

    private ?SmsLength $smsLength = null;

    protected function rules()
    {
        return [
            'selected_tags' => '',
            'message' => 'required',
            'message_type' => 'in:single,multiple',
            'recipient' => 'required_if:message_type,single|regex:/\+?[0-9]{0,11}/',
            'contactList' => 'required_if:message_type,multiple|exists:contact_lists,id',
            'selectedTemplate' => '',
        ];
    }

    public function mount()
    {
        $customer = auth()->user()->currentCustomer;

        $this->tags = $customer->tags->pluck('name')->toArray();
        $this->lists = $customer->lists;
        $this->templates = $customer->templates;
        $this->selectedTemplate = $this->templates->first()?->id ?? '';
    }

    public function render()
    {
        $this->smsLength = new SmsLength($this->message);

        return view('livewire.messages.create-message-form');
    }

    public function updatedMessageType()
    {
        $this->contactList = '';
        $this->recipient = '';
    }

    public function applyTemplate()
    {
        $template = Template::find($this->selectedTemplate);
        $content = optional($template)->content;
        if (is_null($content)) {
            $content = '';
        }
        $this->selected_tags = $template->tags->pluck('name')->toArray();
        $this->message = $content;
    }

    public function updatedMessage()
    {
        $this->smsLength = new SmsLength($this->message);
    }

    public function getMessageEncodingProperty(): string
    {
        return $this->smsLength?->getEncoding() ?? '';
    }

    public function getMessageSizeProperty(): int
    {
        return $this->smsLength?->getSize() ?? 0;
    }

    public function getMessageCountProperty(): int
    {
        $count = $this->smsLength?->getMessageCount() ?? 0;

        return $count * $this->recipientCount;
    }

    public function getRecipientCountProperty(): int
    {
        return ($this->message_type === 'multiple' ? ContactList::find($this->contactList)?->contacts()?->count() : 1) ?? 1;
    }

    public function getMessageUpperBreakpointProperty(): int
    {
        return $this->smsLength?->getUpperBreakpoint() ?? 0;
    }

    public function back()
    {
        return redirect()->route('messages.index');
    }

    public function createMessage()
    {
        $this->validate();
        $customer = auth()->user()->currentCustomer;

        $tags = Tag::where('customer_id', $customer->id)->whereIn('name', $this->selected_tags)->pluck('id')->toArray();

        info('Validated successfully.');
        if ($this->message_type === 'single') {
            info('Dispatching SendSingleMessage job');
            SendSingleMessage::dispatch($this->recipient, $customer->senderId, $this->message, $tags, $customer->id);
        }

        if ($this->message_type === 'multiple') {
            info('Dispatching SendBulkMessage job');
            SendBulkMessage::dispatch($this->contactList, $customer->senderId, $this->message, $tags, $customer->id);
        }

        return redirect()->route('messages.index');
    }
}
