<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use App\Mail\SubscriptionExpire;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSubscriptionExpire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Customer $customer, private string $expire)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
// Customer::get();
Mail::to('karimashraf841@gmail.com')->send(new SubscriptionExpire($this->customer,$this->expire));
    }
}
