<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('ads_balance', 28, 8)->default(0)->after('balance');
            $table->decimal('referral_balance', 28, 8)->default(0)->after('ads_balance');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ads_balance', 'referral_balance']);
        });
    }
};
