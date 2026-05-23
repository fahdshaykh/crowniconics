<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\Payment;
use App\Enums\SubscriptionStatus;
use App\Enums\PaymentStatus;
use Illuminate\Console\Command;

class FixPendingSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:fix-pending {--dry-run : Show what would be fixed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix pending subscriptions that have successful payments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Checking for pending subscriptions with successful payments...');
        
        // Find all pending subscriptions
        $pendingSubscriptions = Subscription::where('status', SubscriptionStatus::PENDING)
            ->with(['user', 'plan', 'payments'])
            ->get();
        
        if ($pendingSubscriptions->isEmpty()) {
            $this->info('✅ No pending subscriptions found.');
            return;
        }
        
        $this->info("Found {$pendingSubscriptions->count()} pending subscriptions.");
        
        $fixedCount = 0;
        $skippedCount = 0;
        
        foreach ($pendingSubscriptions as $subscription) {
            $this->line("Checking subscription ID: {$subscription->id}");
            $this->line("  User: {$subscription->user->name} ({$subscription->user->email})");
            $this->line("  Plan: {$subscription->plan->name}");
            $this->line("  Amount: {$subscription->currency} {$subscription->amount}");
            
            // Check if there's a successful payment
            $payment = $subscription->payments()->latest()->first();
            
            if ($payment && $payment->status === PaymentStatus::SUCCEEDED) {
                $this->line("  ✅ Has successful payment - will be activated");
                
                if (!$this->option('dry-run')) {
                    $subscription->update([
                        'status' => SubscriptionStatus::ACTIVE,
                        'starts_at' => now(),
                    ]);
                    $this->line("  ✅ Subscription activated");
                    $fixedCount++;
                } else {
                    $this->line("  🔍 Would activate (dry run)");
                    $fixedCount++;
                }
            } else {
                $this->line("  ❌ No successful payment found - skipping");
                $skippedCount++;
            }
            
            $this->line('');
        }
        
        if ($this->option('dry-run')) {
            $this->info("🔍 Dry run complete:");
            $this->info("  Would fix: {$fixedCount} subscriptions");
            $this->info("  Would skip: {$skippedCount} subscriptions");
        } else {
            $this->info("✅ Fix complete:");
            $this->info("  Fixed: {$fixedCount} subscriptions");
            $this->info("  Skipped: {$skippedCount} subscriptions");
        }
        
        if ($fixedCount > 0) {
            $this->info("🎉 Users can now access property management!");
        }
    }
}