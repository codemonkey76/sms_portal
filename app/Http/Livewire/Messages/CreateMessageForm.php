<?php

namespace App\Http\Livewire\Messages;

use App\Models\Message;
use Codemonkey76\Twilio\TwilioService;
use Livewire\Component;
use Livewire\WithPagination;
use Phlib\SmsLength\SmsLength;

class CreateMessageForm extends Component
{
    use WithPagination;

    public string $message = '';
    public string $recipient = '';
    private ?SmsLength $smsLength = null;

    protected $rules = [
        'recipient' => 'required|regex:/\+?[0-9]{0,11}/',
        'message' => 'required'
    ];

    public function render()
    {
        $this->smsLength = new SmsLength($this->message);
        return view('livewire.messages.create-message-form');
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
        return $this->smsLength?->getMessageCount() ?? 0;
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

        $twilioMessage = TwilioService::make()
            ->from(auth()->user()->customer->senderId)
            ->to($this->recipient)
            ->message($this->message);

        if (!$twilioMessage) {
            request()->session()->flash('flash.banner', 'Message send failed');
            request()->session()->flash('flash.bannerStyle', 'danger');
            return redirect()->route('messages.index');
        }

        $data = [
            'body' => $twilioMessage->body,
            'user_id' => auth()->id(),
            'customer_id' => auth()->user()->customer_id,
            'numSegments' => $twilioMessage->numSegments,
            'from' => $twilioMessage->from,
            'to' => $twilioMessage->to,
            'status' => $twilioMessage->status,
            'sid' => $twilioMessage->sid,
            'dateUpdated' => $twilioMessage->dateUpdated,
            'dateSent' => $twilioMessage->dateSent,
            'dateCreated' => $twilioMessage->dateCreated
        ];
        info($data);
        Message::create($data);

        return redirect()->route('messages.index');
    }
}
