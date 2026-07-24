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
        Schema::create('incentives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained()->cascadeOnDelete();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->unsignedBigInteger('amount');
            $table->string('status')->default('pending');
            $table->dateTime('earned_at')->nullable();
            $table->timestamps();

            $table->unique(['merchant_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incentives');
    }
};
