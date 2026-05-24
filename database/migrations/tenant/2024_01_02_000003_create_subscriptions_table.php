<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * جدول الاشتراكات داخل كل شركة
 * يتتبع تاريخ الاشتراكات والتجديدات
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->enum('plan', ['basic', 'pro', 'enterprise']);
            $table->decimal('price', 8, 2);
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->string('payment_reference')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
