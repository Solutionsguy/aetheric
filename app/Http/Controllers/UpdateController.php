<?php

namespace App\Http\Controllers;

use App\Enums\PlanHistoryStatus;
use App\Models\PlanHistory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    const LatestVersion = '2.0';

    public function __invoke()
    {
        $this->updateToV20();
    }

    public function updateToV20()
    {
        $this->output('Checking verison...');

        if ($this->checkLatestVersionInstalled() === false) {
            return;
        }

        $migrationPath = 'database/migrations/2024_12_23_120150_v20.php';

        try {
            // Updating the database
            $this->output('Starting database update...');

            try {
                Artisan::call('migrate', [
                    '--path' => $migrationPath,
                    '--force' => true,
                ]);
            } catch (\Throwable $th) {
                $this->output('Migration failed: ' . $th->getMessage());

                return;
            }

            $this->output('Database updated successfully.');

            DB::beginTransaction();

            // Updating existing plan history data
            PlanHistory::chunk(200, function ($planHistories) {
                foreach ($planHistories as $planHistory) {
                    $planHistory->daily_ads_limit = $planHistory->plan?->daily_limit ?? 0;
                    $planHistory->status = now()->gt(now()->parse($planHistory->validity_at)) ? PlanHistoryStatus::EXPIRED : PlanHistoryStatus::ACTIVE;
                    $planHistory->referral_level = $planHistory->plan?->referral_level ?? 0;
                    $planHistory->withdraw_limit = $planHistory->plan?->withdraw_limit ?? 0;
                    $planHistory->save();
                }
            });

            $this->output('Existing plan history data updated successfully');

            DB::commit();

            // Updating the version in the app.php configuration
            $this->configUpdate('app.php', "'version' => '1.0'", "'version' => '2.0'");

            $this->output('Update completed successfully');

            return;
        } catch (\Throwable $th) {
            DB::rollBack();

            // Rollback the migration
            Artisan::call('migrate:rollback', [
                '--path' => $migrationPath,
                '--force' => true,
            ]);

            $this->output('An error occured. Rolling back...');
            $this->output('Error: ' . $th->getMessage());
        }
    }

    protected function configUpdate($configPath, $search, $replace)
    {
        try {
            // Get the file of the app.php configuration
            $appConfigPath = config_path($configPath);

            // Original Configuration
            $originalConfig = file_get_contents($appConfigPath);
            // Replace Configuration and update the version to 2.0
            $replaceConfig = str_replace($search, $replace, $originalConfig);
            file_put_contents($appConfigPath, $replaceConfig);

            $this->output('Configuration updated successfully');
        } catch (\Throwable $th) {
            // Rollback configuration to the original
            file_put_contents($appConfigPath, $originalConfig);
            $this->output('An error occurred while updating the configuration. Rolling back...');
        }
    }

    protected function checkLatestVersionInstalled()
    {
        $currentVersion = config('app.version');
        $latestVersion = self::LatestVersion;

        if ($currentVersion == $latestVersion) {
            $this->output("The latest version v{$latestVersion} is installed.");

            return false;
        }
        $this->output("Updating v{$latestVersion}....");
    }

    protected function output($message)
    {
        echo $message . '</br>';
    }
}
