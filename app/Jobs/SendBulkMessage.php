<?php

namespace App\Jobs;

use App\Models\Contact;
use App\Models\ContactList;
use App\Models\Message;
use Codemonkey76\ClickSend\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

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

        $list->contacts()->each(function($contact) {
            $message = $this->replaceFields($this->message, $contact);
            SendSingleMessage::dispatch($contact->number, $this->senderId, $message, $this->customerId);
        });
    }

    private function replaceFields(string $message, Contact $contact)
    {
        return Str::of($message)
            ->replace('<<first_name>>', $contact->first_name)
            ->replace('<<last_name>>', $contact->last_name)
            ->replace('<<company_name>>', $contact->company_name)
            ->replace('<<number>>', $contact->number);
    }
}
