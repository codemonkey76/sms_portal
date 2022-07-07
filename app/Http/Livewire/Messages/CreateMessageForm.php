<?php

namespace App\Http\Livewire\Messages;

use App\Events\MessageSent;
use App\Jobs\CheckMessageStatus;
use App\Models\Message;
use App\Models\Template;
use ClickSend\Api\SMSApi;
use ClickSend\Configuration;
use ClickSend\Model\SmsMessage;
use ClickSend\Model\SmsMessageCollection;
use ClickSend\Model\Url;
use Codemonkey76\ClickSend\ClickSend;
use Codemonkey76\Twilio\TwilioService;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Phlib\SmsLength\SmsLength;

class CreateMessageForm extends Component
{
    use WithPagination;

    public $templates;
    public string $message = '';
    public string $recipient = '';
    public ?string $selectedTemplate;
    private ?SmsLength $smsLength = null;

    protected $rules = [
        'recipient' => 'required|regex:/\+?[0-9]{0,11}/',
        'message' => 'required',
        'selectedTemplate' => ''
    ];

    public function mount()
    {
        $this->templates = auth()->user()->currentCustomer->templates;
        $this->selectedTemplate = optional($this->templates->first())->id ?? '';
    }
    public function render()
    {
        $this->smsLength = new SmsLength($this->message);
        return view('livewire.messages.create-message-form');
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
        return optional($this->smsLength)->getMessageCount() ?? 0;
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

        $clickSend = ClickSend::make()
            ->from(auth()->user()->currentCustomer->senderId)
            ->to($this->recipient)
            ->message($this->message);

        if ($clickSend->send()) {
            $result = json_decode($clickSend->getLastResult());
            $sms = $result->data->messages[0];

            $data = [
                'body' => $sms->body,
                'user_id' => auth()->id(),
                'customer_id' => auth()->user()->current_customer_id,
                'numSegments' => $sms->message_parts,
                'from' => $sms->from,
                'to' => $sms->to,
                'status' => 'queued',
                'sid' => $sms->message_id,
                'dateUpdated' => now(),
                'dateSent' => null,
                'dateCreated' => now()
            ];
            $message = Message::create($data);
        }

        return redirect()->route('messages.index');
    }
}
