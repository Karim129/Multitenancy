<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Console\Command;
use App\Jobs\SendSubscriptionExpire;

class SubscriptionExpireNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:SubscriptionExpireNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check subscription expire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
$customers=Customer::where('subscription_date', '<', now())->get();
// dd($customers->toArray());
foreach($customers as $customer){
    // info($customer->toArray());
    $expire=Carbon::createFromFormat('Y-m-d', $customer->subscription_date)->toString();
    dispatch(new SendSubscriptionExpire($customer,$expire))   ->onQueue('notification');
}


    }
}
