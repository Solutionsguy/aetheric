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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description');
            $table->decimal('price');
            $table->integer('daily_limit');
            $table->integer('validity');
            $table->integer('withdraw_limit')->default(0);
            $table->integer('referral_level')->default(0);
            $table->string('badge');
            $table->boolean('is_featured');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
