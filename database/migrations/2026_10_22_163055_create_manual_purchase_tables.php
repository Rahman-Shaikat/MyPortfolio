<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('type');
            $table->char('currency', 3);
            $table->text('instructions')->nullable();
            $table->boolean('enabled')->default(false);
            $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('submission_hash', 64)->unique();
            $table->string('payload_hash', 64);
            $table->string('name', 120);
            $table->string('phone', 40);
            $table->string('email');
            $table->string('status')->default('pending')->index();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('product');
            $table->decimal('amount', 10, 2);
            $table->char('currency', 3);
            $table->string('payment_method');
            $table->string('payment_method_name');
            $table->text('payment_instructions');
            $table->string('payment_reference', 120);
            $table->string('reference_fingerprint', 64)->index();
            $table->string('bank_sender_name', 120)->nullable();
            $table->char('bank_last_four', 4)->nullable();
            $table->string('screenshot_path')->nullable();
            $table->timestamps();
        });
        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->text('reason')->nullable();
            $table->string('actor');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('payment_methods');
    }
};
