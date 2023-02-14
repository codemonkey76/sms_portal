<?php

namespace App\Jobs;

use App\Models\ContactList;
use App\Models\Message;
use Codemonkey76\ClickSend\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBulkMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $recipient_list, public string $senderId, public string $message, public string $customerId) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $list = ContactList::find(intval($this->recipient_list));

        $list->contacts()->each(fn($contact) => SendSingleMessage::dispatch($contact->number, $this->senderId, $this->message, $this->customerId));
    }
}
