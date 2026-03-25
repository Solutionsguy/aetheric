<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('admins', 'is_admin')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->tinyInteger('is_admin')->default(0);
            });
        }

        // Mark existing super admins (those with the Super-Admin role)
        DB::statement("
            UPDATE admins
            SET is_admin = 1
            WHERE id IN (
                SELECT model_id FROM model_has_roles
                WHERE role_id = (SELECT id FROM roles WHERE name = 'Super-Admin')
                AND model_type = 'App\\\\Models\\\\Admin'
            )
        ");
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
};
