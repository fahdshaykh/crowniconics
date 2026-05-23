<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update expired subscriptions status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired subscriptions...');

        $expiredSubscriptions = Subscription::where('status', 'active')
            ->where('ends_at', '<', now())
            ->get();

        if ($expiredSubscriptions->isEmpty()) {
            $this->info('No expired subscriptions found.');
            return;
        }

        $count = 0;
        foreach ($expiredSubscriptions as $subscription) {
            $subscription->update([
                'status' => 'expired',
                'ends_at' => now()
            ]);
            
            $this->line("Expired subscription for user: {$subscription->user->email}");
            $count++;
        }

        $this->info("Updated {$count} expired subscriptions.");
    }
}
