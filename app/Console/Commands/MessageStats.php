<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;

class MessageStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:stats
                            {--customer= : The customer you want to report on}
                            {--month=1 : How many months prior to look at, default=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the message stats';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Message Statistics Report");
        $monthsAgo = $this->option('month');
        $customerId = $this->option('customer');
        $customer = Customer::find($customerId);

        if (!is_null($customer)) {
            $start = now()->subMonths($monthsAgo)->startOfMonth();
            $end = now()->subMonths($monthsAgo)->endOfMonth();

            $this->info("--------------------------------------------------------------------");
            $this->info("Message report for: ".Customer::find($customerId)->name);
            $this->info("--------------------------------------------------------------------");
            $this->info("Messages between {$start} and {$end}");

            $query = Customer::find($customerId)->messages()->where('dateCreated', '>', $start)->where('dateCreated',
                '<', $end);

            $this->info("Num messages: {$query->count()}");
            $this->info("Num credits: {$query->sum('numSegments')}");
        } else {
            $this->error("Customer not found!");
        }
        return 0;
    }
}
