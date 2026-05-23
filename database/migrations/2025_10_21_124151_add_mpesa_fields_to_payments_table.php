<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Add M-Pesa specific fields
            $table->string('mpesa_receipt_number')->nullable()->after('payment_method_details');
            $table->string('mpesa_transaction_id')->nullable()->after('mpesa_receipt_number');
            $table->string('mpesa_phone_number')->nullable()->after('mpesa_transaction_id');
            $table->string('mpesa_account_reference')->nullable()->after('mpesa_phone_number');
            $table->string('mpesa_transaction_description')->nullable()->after('mpesa_account_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'mpesa_receipt_number',
                'mpesa_transaction_id',
                'mpesa_phone_number',
                'mpesa_account_reference',
                'mpesa_transaction_description',
            ]);
        });
    }
};
