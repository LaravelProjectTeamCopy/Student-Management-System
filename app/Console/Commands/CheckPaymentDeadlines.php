<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Financial;

class CheckPaymentDeadlines extends Command
{
    protected $signature = 'app:check-payment-deadlines';
    protected $description = 'Mark overdue payments past their deadline';

    public function handle()
    {
        Financial::where('payment_status', '!=', 'Paid')
            ->where('deadline', '<', now())
            ->whereNotNull('deadline')
            ->update(['payment_status' => 'Overdue']);

        $this->info('Payment deadlines checked successfully.');
        
    }
}