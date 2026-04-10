<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserNavigation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        UserNavigation::create([
            'type' => 'investments',
            'icon' => 'icon-money-receive',
            'url' => 'user/investments',
            'name' => 'Investment Plans',
            'position' => 2,
        ]);

        // Shift others forward
        UserNavigation::where('type', '!=', 'investments')
            ->where('position', '>=', 2)
            ->increment('position');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        UserNavigation::where('type', 'investments')->delete();
        UserNavigation::where('position', '>', 2)->decrement('position');
    }
};
