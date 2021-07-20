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
        return $this->smsLength?->getSize()?? 0;
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
            ->from('AlphaIT')
            ->to($this->recipient)
            ->message($this->message);

        auth()->user()->customer->messages()->create([
            'body' => $twilioMessage->body,
            'user_id' => auth()->id(),
            'numSegments' => $twilioMessage->numSegments,
            'from' => $twilioMessage->from,
            'to' => $twilioMessage->to,
            'status' => $twilioMessage->status,
            'sid' => $twilioMessage->sid,
            'dateUpdated' => $twilioMessage->dateUpdated,
            'dateSent' => $twilioMessage->dateSent,
            'dateCreated' => $twilioMessage->dateCreated
        ]);

        return redirect()->route('messages.index');
    }
}
