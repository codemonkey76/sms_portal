<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\Tag;
use Codemonkey76\ClickSend\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSingleMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public string $recipient, public string $senderId, public string $message, public array $tags, public string $customerId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $m = new SmsMessage($this->recipient, $this->senderId, $this->message);
        $response = \ClickSend::sendMessage($m);

        if ($response) {

            $m = Message::create([
                'body' => $this->message,
                'user_id' => auth()->id(),
                'customer_id' => $this->customerId,
                'numSegments' => $response->data->messages[0]->message_parts,
                'from' => $response->data->messages[0]->from,
                'to' => $response->data->messages[0]->to,
                'sid' => $response->data->messages[0]->message_id,
                'status' => 'queued',
                'dateUpdated' => now(),
                'dateSent' => null,
                'dateCreated' => now(),
            ]);

            $m->tags()->attach($this->tags);
        }
    }
}
