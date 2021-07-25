<?php

namespace App\Jobs;

use App\Models\Message;
use Codemonkey76\ClickSend\ClickSend;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckMessageStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Message $message;


    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        info('Running Job to check the message status');
        $result = ClickSend::make()->getReceipt($this->message->sid);
        info(json_encode($result));
    }
}
