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
        Schema::dropIfExists('coupon_redemptions');
        Schema::dropIfExists('contents');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('channel');
            $table->string('coupon_code')->unique();
            $table->unsignedInteger('reach')->default(0);
            $table->dateTime('published_at');
            $table->timestamps();
        });

        Schema::create('coupon_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->cascadeOnDelete();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained()->cascadeOnDelete();
            $table->dateTime('redeemed_at');
            $table->timestamps();
        });
    }
};
