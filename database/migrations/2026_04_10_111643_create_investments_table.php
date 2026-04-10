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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('investment_plans')->onDelete('cascade');
            $table->decimal('amount', 28, 8);
            $table->decimal('total_profit', 28, 8)->default(0);
            $table->integer('installments_paid')->default(0);
            $table->integer('total_installments'); // copied from plan duration at time of investment
            $table->timestamp('last_return_at')->nullable();
            $table->timestamp('next_return_at')->nullable();
            $table->string('status')->default('running'); // running, completed, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
