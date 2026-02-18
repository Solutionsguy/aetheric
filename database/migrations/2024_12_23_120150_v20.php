<?php

use App\Enums\PlanHistoryStatus;
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
        // Update the plan_histories table
        Schema::table('plan_histories', function (Blueprint $table) {
            $table->integer('daily_ads_limit')->default(0)->after('plan_id');
            $table->string('status')->default(PlanHistoryStatus::ACTIVE->value)->after('amount');
            $table->integer('referral_level')->default(0)->after('daily_ads_limit');
            $table->integer('withdraw_limit')->default(0)->after('referral_level');
        });

        // Update the ads_histories table
        Schema::table('ads_histories', function (Blueprint $table) {
            $table->foreignId('plan_id')->nullable()->after('ads_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback changes to the plan_histories table
        Schema::table('plan_histories', function (Blueprint $table) {
            $table->dropColumn(['daily_ads_limit', 'status', 'referral_level', 'withdraw_limit']);
        });

        // Rollback changes to the ads_histories table
        Schema::table('ads_histories', function (Blueprint $table) {
            $table->dropColumn('plan_id');
        });
    }
};
