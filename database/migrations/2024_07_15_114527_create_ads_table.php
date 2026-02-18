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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('plan_id')->nullable();
            $table->enum('for',['free_users','subscribed_users','both_users'])->default('subscribed_users');
            $table->text('title');
            $table->decimal('amount');
            $table->string('type')->comment('type=link,script,image,youtube'); 
            $table->text('value');
            $table->integer('duration');
            $table->integer('max_views');
            $table->integer('total_views')->default(0);
            $table->integer('remaining_views')->default(0);
            $table->json('schedules')->nullable();
            $table->enum('status',['active','inactive','pending','rejected']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
