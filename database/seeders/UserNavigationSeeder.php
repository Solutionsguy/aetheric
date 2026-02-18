<?php

namespace Database\Seeders;

use App\Models\UserNavigation;
use Illuminate\Database\Seeder;

class UserNavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserNavigation::truncate();

        $navigations = [
            [
                'type' => 'dashboard',
                'icon' => 'icon-element-3',
                'url' => 'user/dashboard',
                'name' => 'Dashboard',
                'position' => 1,
            ],
            [
                'type' => 'subscriptions',
                'icon' => 'icon-empty-wallet',
                'url' => 'user/subscriptions',
                'name' => 'Subscriptions',
                'position' => 2,
            ],
            [
                'type' => 'deposit',
                'icon' => 'icon-dollar-square',
                'url' => 'user/deposit',
                'name' => 'Deposit',
                'position' => 3,
            ],
            [
                'type' => 'fund_transfer',
                'icon' => 'icon-repeat-circle',
                'url' => 'user/fund-transfer',
                'name' => 'Fund Transfer',
                'position' => 4,
            ],
            [
                'type' => 'earnings',
                'icon' => 'icon-dollar-circle',
                'url' => 'user/earnings',
                'name' => 'My Earnings',
                'position' => 5,
            ],
            [
                'type' => 'my_ads',
                'icon' => 'icon-tag-user',
                'url' => 'user/ads',
                'name' => 'All Ads',
                'position' => 6,
            ],
            [
                'type' => 'transactions',
                'icon' => 'icon-arrange-square',
                'url' => 'user/transactions',
                'name' => 'Transactions',
                'position' => 7,
            ],
            [
                'type' => 'withdraw',
                'icon' => 'icon-money-send',
                'url' => 'user/withdraw',
                'name' => 'Withdraw',
                'position' => 8,
            ],
            [
                'type' => 'referral',
                'icon' => 'icon-profile-2user',
                'url' => 'user/referral',
                'name' => 'Referral',
                'position' => 9,
            ],
            [
                'type' => 'support',
                'icon' => 'icon-support',
                'url' => 'user/support-ticket/index',
                'name' => 'Support',
                'position' => 10,
            ],
            [
                'type' => 'settings',
                'icon' => 'icon-setting-2',
                'url' => 'user/settings',
                'name' => 'Settings',
                'position' => 11,
            ],
        ];

        UserNavigation::insert($navigations);
    }
}
