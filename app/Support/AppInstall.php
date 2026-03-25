<?php

namespace App\Support;

class AppInstall
{
    /**
     * Determine if the application has been installed.
     *
     * Many parts of the codebase depend on this guard to prevent balance updates
     * and other operations before the installer completes.
     */
    public static function initApp(): bool
    {
        return file_exists(storage_path('installed'));
    }

    /**
     * Check whether the database connection is available.
     *
     * The original codebase relied on an external installer package for this.
     */
    public static function dbConnectionCheck(): bool
    {
        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();

            return true;
        } catch (\Throwable) {
            return false;
        }
    }
}
