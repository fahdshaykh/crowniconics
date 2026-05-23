<?php

namespace Database\Seeders;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('💳 Seeding payments...');

        $users = User::has('subscriptions')->with('subscriptions')->get();
        $paymentsCreated = 0;

        foreach ($users as $user) {
            foreach ($user->subscriptions as $subscription) {
                // Create 1-6 payments per subscription
                $paymentCount = rand(1, 6);

                for ($i = 0; $i < $paymentCount; $i++) {
                    $paymentData = $this->generatePaymentData($user, $subscription, $i);
                    
                    Payment::create($paymentData);
                    $paymentsCreated++;
                }
            }
        }

        // Create specific demo payments
        $this->createDemoPayments();

        $this->command->info("✅ {$paymentsCreated} payments seeded successfully!");
    }

    private function generatePaymentData(User $user, Subscription $subscription, int $index): array
    {
        $statusOptions = [
            PaymentStatusEnum::SUCCEEDED->value => 80,
            PaymentStatusEnum::PENDING->value => 5,
            PaymentStatusEnum::PROCESSING->value => 5,
            PaymentStatusEnum::FAILED->value => 5,
            PaymentStatusEnum::REFUNDED->value => 3,
            PaymentStatusEnum::CANCELED->value => 2,
        ];

        $status = $this->getWeightedRandomStatus($statusOptions);
        $paymentDate = now()->subMonths($index + 1)->addDays(rand(1, 28));
        $amount = $subscription->amount;
        $taxAmount = $amount * 0.1; // 10% tax
        $totalAmount = $amount + $taxAmount;

        $paymentData = [
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'stripe_payment_intent_id' => 'pi_' . Str::random(14),
            'stripe_invoice_id' => 'in_' . Str::random(14),
            'payment_method' => $this->getRandomPaymentMethod(),
            'amount' => $amount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'currency' => 'USD',
            'status' => $status,
            'type' => 'subscription',
            'billing_name' => $user->billing_name ?? $user->name,
            'billing_email' => $user->billing_email ?? $user->email,
            'billing_phone' => $user->billing_phone ?? $user->phone,
            'billing_address' => $user->billing_address ?? $user->address,
            'billing_city' => $user->billing_city,
            'billing_state' => $user->billing_state,
            'billing_country' => $user->billing_country,
            'billing_zip_code' => $user->billing_zip_code,
            'created_at' => $paymentDate,
            'updated_at' => $paymentDate,
            'metadata' => [
                'subscription_plan' => $subscription->plan->name,
                'billing_cycle' => $subscription->billing_cycle,
                'payment_sequence' => $index + 1,
            ],
            'payment_method_details' => $this->generatePaymentMethodDetails(),
        ];

        // Add status-specific fields
        $paymentData = array_merge($paymentData, $this->getStatusSpecificFields($status, $paymentDate));

        return $paymentData;
    }

    private function getWeightedRandomStatus(array $statusOptions): string
    {
        $total = array_sum($statusOptions);
        $random = rand(1, $total);
        $current = 0;

        foreach ($statusOptions as $status => $weight) {
            $current += $weight;
            if ($random <= $current) {
                return $status;
            }
        }

        return PaymentStatusEnum::SUCCEEDED->value;
    }

    private function getRandomPaymentMethod(): string
    {
        $methods = [
            'card' => 85,
            'bank_transfer' => 10,
            'paypal' => 5,
        ];

        $total = array_sum($methods);
        $random = rand(1, $total);
        $current = 0;

        foreach ($methods as $method => $weight) {
            $current += $weight;
            if ($random <= $current) {
                return $method;
            }
        }

        return 'card';
    }

    private function generatePaymentMethodDetails(): array
    {
        $method = $this->getRandomPaymentMethod();

        switch ($method) {
            case 'card':
                return [
                    'type' => 'card',
                    'card' => [
                        'brand' => $this->getRandomCardBrand(),
                        'last4' => str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                        'exp_month' => rand(1, 12),
                        'exp_year' => date('Y') + rand(1, 5),
                        'country' => 'US',
                    ]
                ];

            case 'bank_transfer':
                return [
                    'type' => 'bank_transfer',
                    'bank_transfer' => [
                        'bank_name' => $this->getRandomBankName(),
                        'account_type' => 'checking',
                        'last4' => str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    ]
                ];

            case 'paypal':
                return [
                    'type' => 'paypal',
                    'paypal' => [
                        'payer_email' => 'payer' . rand(1000, 9999) . '@example.com',
                        'payer_id' => 'PAYER' . Str::random(10),
                    ]
                ];

            default:
                return ['type' => 'card'];
        }
    }

    private function getRandomCardBrand(): string
    {
        $brands = ['visa', 'mastercard', 'amex', 'discover'];
        return $brands[array_rand($brands)];
    }

    private function getRandomBankName(): string
    {
        $banks = ['Chase', 'Bank of America', 'Wells Fargo', 'Citibank', 'US Bank'];
        return $banks[array_rand($banks)];
    }

    private function getStatusSpecificFields(string $status, $paymentDate): array
    {
        $fields = [];

        switch ($status) {
            case PaymentStatusEnum::SUCCEEDED->value:
                $fields['paid_at'] = $paymentDate->copy()->addMinutes(rand(1, 60));
                break;

            case PaymentStatusEnum::FAILED->value:
                $fields['failed_at'] = $paymentDate->copy()->addMinutes(rand(1, 30));
                $fields['failure_code'] = 'card_declined';
                $fields['failure_message'] = 'Your card was declined.';
                break;

            case PaymentStatusEnum::REFUNDED->value:
                $fields['paid_at'] = $paymentDate->copy()->addMinutes(rand(1, 60));
                $fields['refunded_at'] = $paymentDate->copy()->addDays(rand(1, 7));
                break;

            case PaymentStatusEnum::CANCELED->value:
                $fields['failed_at'] = $paymentDate->copy()->addMinutes(rand(1, 10));
                $fields['failure_code'] = 'payment_canceled';
                $fields['failure_message'] = 'Payment was canceled by user.';
                break;
        }

        return $fields;
    }

    private function createDemoPayments(): void
    {
        // Demo payment for agent
        $agent = User::where('email', 'agent@example.com')->first();
        $agentSubscription = $agent->subscriptions()->first();

        if ($agentSubscription) {
            Payment::create([
                'user_id' => $agent->id,
                'subscription_id' => $agentSubscription->id,
                'stripe_payment_intent_id' => 'pi_agentdemo123',
                'stripe_invoice_id' => 'in_agentdemo123',
                'payment_method' => 'card',
                'amount' => 29.99,
                'tax_amount' => 3.00,
                'total_amount' => 32.99,
                'currency' => 'USD',
                'status' => PaymentStatusEnum::SUCCEEDED->value,
                'type' => 'subscription',
                'billing_name' => 'John Doe',
                'billing_email' => 'john.doe@primalestate.com',
                'billing_phone' => '+1234567892',
                'billing_address' => '125 Agent Street, New York, NY 10001',
                'billing_city' => 'New York',
                'billing_state' => 'NY',
                'billing_country' => 'United States',
                'billing_zip_code' => '10001',
                'paid_at' => now()->subDays(15),
                'payment_method_details' => [
                    'type' => 'card',
                    'card' => [
                        'brand' => 'visa',
                        'last4' => '4242',
                        'exp_month' => 12,
                        'exp_year' => 2025,
                        'country' => 'US',
                    ]
                ],
                'metadata' => [
                    'demo_payment' => true,
                    'subscription_plan' => 'Professional',
                ],
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ]);
        }

        // Demo payment for professional
        $professional = User::where('email', 'professional@example.com')->first();
        $professionalSubscription = $professional->subscriptions()->first();

        if ($professionalSubscription) {
            Payment::create([
                'user_id' => $professional->id,
                'subscription_id' => $professionalSubscription->id,
                'stripe_payment_intent_id' => 'pi_prodemo123',
                'stripe_invoice_id' => 'in_prodemo123',
                'payment_method' => 'card',
                'amount' => 799.99,
                'tax_amount' => 80.00,
                'total_amount' => 879.99,
                'currency' => 'USD',
                'status' => PaymentStatusEnum::SUCCEEDED->value,
                'type' => 'subscription',
                'billing_name' => 'Jane Smith',
                'billing_email' => 'professional@example.com',
                'billing_phone' => '+1234567893',
                'billing_address' => '126 Professional Ave, New York, NY 10001',
                'billing_city' => 'New York',
                'billing_state' => 'NY',
                'billing_country' => 'United States',
                'billing_zip_code' => '10001',
                'paid_at' => now()->subDays(90),
                'payment_method_details' => [
                    'type' => 'card',
                    'card' => [
                        'brand' => 'mastercard',
                        'last4' => '5555',
                        'exp_month' => 6,
                        'exp_year' => 2026,
                        'country' => 'US',
                    ]
                ],
                'metadata' => [
                    'demo_payment' => true,
                    'subscription_plan' => 'Agency',
                    'billing_cycle' => 'yearly',
                ],
                'created_at' => now()->subDays(90),
                'updated_at' => now()->subDays(90),
            ]);
        }
    }
}