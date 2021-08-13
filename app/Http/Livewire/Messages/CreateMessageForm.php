<?php

namespace App\Http\Livewire\Messages;

use App\Events\MessageSent;
use App\Jobs\CheckMessageStatus;
use App\Models\Message;
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
            $url = new Url();
            $url->setUrl('http://sms.staging.asgcom.net');
            $message = Message::create($data);

            //CheckMessageStatus::dispatch($message)->delay(now()->addSeconds(60));


//            $testResult = (object)[
//                "http_code" => 200,
//                "response_code" => "SUCCESS",
//                "response_msg" => "Message queued for  delivery",
//                "data" => (object)[
//                    "total_price" => 0.077,
//                    "total_count" => 1,
//                    "queued_count" => 1,
//                    "messages" => [
//                        (object)[
//                            "direction" => "out",
//                            "date" => 1627008719,
//                            "to" => "+61400588588",
//                            "body" => "Testing from form 987",
//                            "from" => "AlphaIT",
//                            "schedule" => 0,
//                            "message_id" => "35434220-BF1E-4963-B3ED-9F4DD856671E",
//                            "message_parts" => 1,
//                            "message_price" => "0.0770",
//                            "from_email" => null,
//                            "list_id" => null,
//                            "custom_string" => "",
//                            "contact_id" => null,
//                            "user_id" => 255899,
//                            "subaccount_id" => 290729,
//                            "country" => "AU",
//                            "carrier" => "Telstra",
//                            "status" => "SUCCESS"
//                        ]
//                    ],
//                    "_currency" => (object)[
//                        "currency_name_short" => "AUD",
//                        "currency_prefix_d" => "$",
//                        "currency_prefix_c" => "c",
//                        "currency_name_long" => "Australian Dollars"
//                    ]
//                ]
//            ];
        }


//        $twilioMessage = TwilioService::make()
//            ->from(auth()->user()->customer->senderId)
//            ->to($this->recipient)
//            ->message($this->message);

//        if (!$twilioMessage) {
//            request()->session()->flash('flash.banner', 'Message send failed');
//            request()->session()->flash('flash.bannerStyle', 'danger');
//            return redirect()->route('messages.index');
//        }

//        $data = [
//            'body' => $twilioMessage->body,
//            'user_id' => auth()->id(),
//            'customer_id' => auth()->user()->customer_id,
//            'numSegments' => $twilioMessage->numSegments,
//            'from' => $twilioMessage->from,
//            'to' => $twilioMessage->to,
//            'status' => $twilioMessage->status,
//            'sid' => $twilioMessage->sid,
//            'dateUpdated' => $twilioMessage->dateUpdated,
//            'dateSent' => $twilioMessage->dateSent,
//            'dateCreated' => $twilioMessage->dateCreated
//        ];
//        info($data);
//        Message::create($data);

        return redirect()->route('messages.index');
    }
}
