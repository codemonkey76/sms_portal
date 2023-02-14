<?php

namespace App\Http\Livewire\Messages;

use App\Events\MessageSent;
use App\Jobs\CheckMessageStatus;
use App\Jobs\SendBulkMessage;
use App\Jobs\SendSingleMessage;
use App\Models\ContactList;
use App\Models\Message;
use App\Models\Template;
use ClickSend\Api\SMSApi;
use ClickSend\Configuration;
use ClickSend\Model\SmsMessageCollection;
use ClickSend\Model\Url;
use Codemonkey76\ClickSend\SmsMessage;
use Codemonkey76\Twilio\TwilioService;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Phlib\SmsLength\SmsLength;

class CreateMessageForm extends Component
{
    use WithPagination;

    public $templates;
    public $lists;
    public string $message = '';
    public string $recipient = '';
    public string $message_type = 'single';
    public string $contactList = '';
    public ?string $selectedTemplate;
    private ?SmsLength $smsLength = null;

    protected function rules()
    {
        return [
            'recipient' => 'required|regex:/\+?[0-9]{0,11}/',
            'message' => 'required',
            'message_type' => 'in:single,multiple',
            'contactList' => 'required_if:message_type,multiple|exists:contact_lists,id',
            'selectedTemplate' => ''
        ];
    }

    public function mount()
    {
        $this->lists = auth()->user()->currentCustomer->lists;
        $this->templates = auth()->user()->currentCustomer->templates;
        $this->selectedTemplate = optional($this->templates->first())->id ?? '';
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
        $content = optional(Template::find($this->selectedTemplate))->content;
        if (is_null($content)) {
            $content = '';
        }
        $this->message = $content;
    }

    public function updatedMessage()
    {
        $this->smsLength = new SmsLength($this->message);
    }

    public function getMessageEncodingProperty(): string
    {
        return optional($this->smsLength)->getEncoding() ?? '';
    }

    public function getMessageSizeProperty(): int
    {
        return optional($this->smsLength)->getSize() ?? 0;
    }

    public function getMessageCountProperty(): int
    {
        $count = optional($this->smsLength)->getMessageCount() ?? 0;
        return $count * $this->recipientCount;

    }

    public function getRecipientCountProperty(): int
    {
        return ($this->message_type === 'multiple' ? ContactList::find($this->contactList)?->contacts()?->count() : 1) ?? 1;
    }

    public function getMessageUpperBreakpointProperty(): int
    {
        return optional($this->smsLength)->getUpperBreakpoint() ?? 0;
    }

    public function back()
    {
        return redirect()->route('messages.index');
    }

    public function createMessage()
    {
        $this->validate();

        if ($this->message_type === 'single')
            SendSingleMessage::dispatch($this->recipient, auth()->user()->currentCustomer->senderId, $this->message);

        if ($this->message_type === 'multiple')
            SendBulkMessage::dispatch($this->contactList, auth()->user()->currentCustomer->senderId, $this->message);

        return redirect()->route('messages.index');
    }
}
