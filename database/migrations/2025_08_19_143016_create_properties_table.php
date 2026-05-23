<?php

use App\Enums\BooleanEnum;
use App\Enums\PropertyStatusEnum;
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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('properties')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('type_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->nullable();

            $table->string('slug');
            $table->string('title');
            $table->string('meta_title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(BooleanEnum::FALSE->value);
            $table->enum('status', [
                PropertyStatusEnum::ACTIVE->value,
                PropertyStatusEnum::INACTIVE->value,
                PropertyStatusEnum::APPROVED->value,
                PropertyStatusEnum::REJECTED->value,
                PropertyStatusEnum::AVAILABLE->value,
                PropertyStatusEnum::SOLD->value,
                PropertyStatusEnum::RENTED->value,
                PropertyStatusEnum::DRAFT->value,
            ])->default(PropertyStatusEnum::DRAFT->value);

            // ✅ Add these fields to match Seeder
            $table->string('country_id')->nullable();
            $table->string('state_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('address')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('currency', 10)->nullable()->default('USD');
            $table->string('reference_number')->nullable();

            $table->string('price_type')->nullable();
            $table->integer('beds')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('area_sqft')->nullable();
            $table->integer('parking')->nullable();

            $table->string('featured_image')->nullable();
            $table->text('images')->nullable();
                        $table->string('video_url')->nullable();
            $table->text('features')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
