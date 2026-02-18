<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [

            ['category' => 'Statistics Management', 'name' => 'total-users'],
            ['category' => 'Statistics Management', 'name' => 'active-users'],
            ['category' => 'Statistics Management', 'name' => 'disabled-users'],
            ['category' => 'Statistics Management', 'name' => 'total-staff'],
            ['category' => 'Statistics Management', 'name' => 'total-deposits'],
            ['category' => 'Statistics Management', 'name' => 'total-withdraw'],
            ['category' => 'Statistics Management', 'name' => 'total-referral'],
            ['category' => 'Statistics Management', 'name' => 'total-fund-transfer'],
            ['category' => 'Statistics Management', 'name' => 'total-ads'],
            ['category' => 'Statistics Management', 'name' => 'total-ads-earnings'],
            ['category' => 'Statistics Management', 'name' => 'total-automatic-gateway'],
            ['category' => 'Statistics Management', 'name' => 'total-ticket'],
            ['category' => 'Statistics Management', 'name' => 'site-statistics-chart'],
            ['category' => 'Statistics Management', 'name' => 'fund-transfer-statistics'],

            ['category' => 'Statistics Management', 'name' => 'top-country-statistics'],
            ['category' => 'Statistics Management', 'name' => 'top-browser-statistics'],
            ['category' => 'Statistics Management', 'name' => 'top-os-statistics'],
            ['category' => 'Statistics Management', 'name' => 'latest-users'],

            ['category' => 'Customer Management', 'name' => 'customer-list'],
            ['category' => 'Customer Management', 'name' => 'customer-login'],
            ['category' => 'Customer Management', 'name' => 'customer-mail-send'],
            ['category' => 'Customer Management', 'name' => 'customer-basic-manage'],
            ['category' => 'Customer Management', 'name' => 'customer-balance-add-or-subtract'],
            ['category' => 'Customer Management', 'name' => 'customer-change-password'],
            ['category' => 'Customer Management', 'name' => 'all-type-status'],

            ['category' => 'Kyc Management', 'name' => 'kyc-list'],
            ['category' => 'Kyc Management', 'name' => 'kyc-action'],
            ['category' => 'Kyc Management', 'name' => 'kyc-form-manage'],

            ['category' => 'Role Management', 'name' => 'role-list'],
            ['category' => 'Role Management', 'name' => 'role-create'],
            ['category' => 'Role Management', 'name' => 'role-edit'],

            ['category' => 'Staff Management', 'name' => 'staff-list'],
            ['category' => 'Staff Management', 'name' => 'staff-create'],
            ['category' => 'Staff Management', 'name' => 'staff-edit'],

            ['category' => 'Transaction Management', 'name' => 'transaction-list'],

            ['category' => 'Subscription Plan Management', 'name' => 'plan-list'],
            ['category' => 'Subscription Plan Management', 'name' => 'plan-create'],
            ['category' => 'Subscription Plan Management', 'name' => 'plan-edit'],
            ['category' => 'Subscription Plan Management', 'name' => 'plan-delete'],

            ['category' => 'Ads Management', 'name' => 'all-ads'],
            ['category' => 'Ads Management', 'name' => 'pending-ads'],
            ['category' => 'Ads Management', 'name' => 'active-ads'],
            ['category' => 'Ads Management', 'name' => 'inactive-ads'],
            ['category' => 'Ads Management', 'name' => 'rejected-ads'],
            ['category' => 'Ads Management', 'name' => 'ads-edit'],
            ['category' => 'Ads Management', 'name' => 'ads-create'],
            ['category' => 'Ads Management', 'name' => 'ads-delete'],

            ['category' => 'Ads Reports Management', 'name' => 'ads-report-category-list'],
            ['category' => 'Ads Reports Management', 'name' => 'ads-report-category-create'],
            ['category' => 'Ads Reports Management', 'name' => 'ads-report-category-edit'],
            ['category' => 'Ads Reports Management', 'name' => 'ads-report-category-delete'],
            ['category' => 'Ads Reports Management', 'name' => 'ads-reports-list'],

            ['category' => 'Deposit Management', 'name' => 'automatic-gateway-manage'],
            ['category' => 'Deposit Management', 'name' => 'manual-gateway-manage'],
            ['category' => 'Deposit Management', 'name' => 'deposit-list'],
            ['category' => 'Deposit Management', 'name' => 'deposit-action'],

            ['category' => 'Withdraw Management', 'name' => 'withdraw-list'],
            ['category' => 'Withdraw Management', 'name' => 'withdraw-method-manage'],
            ['category' => 'Withdraw Management', 'name' => 'withdraw-action'],
            ['category' => 'Withdraw Management', 'name' => 'withdraw-schedule'],

            ['category' => 'Referral Management', 'name' => 'manage-referral'],
            ['category' => 'Referral Management', 'name' => 'referral-create'],
            ['category' => 'Referral Management', 'name' => 'referral-edit'],
            ['category' => 'Referral Management', 'name' => 'referral-delete'],

            ['category' => 'Frontend Management', 'name' => 'landing-page-manage'],
            ['category' => 'Frontend Management', 'name' => 'page-manage'],
            ['category' => 'Frontend Management', 'name' => 'footer-manage'],
            ['category' => 'Frontend Management', 'name' => 'navigation-manage'],
            ['category' => 'Frontend Management', 'name' => 'custom-css'],

            ['category' => 'Subscriber Management', 'name' => 'subscriber-list'],
            ['category' => 'Subscriber Management', 'name' => 'subscriber-mail-send'],

            ['category' => 'Support Ticket Management', 'name' => 'support-ticket-list'],
            ['category' => 'Support Ticket Management', 'name' => 'support-ticket-action'],

            ['category' => 'Setting Management', 'name' => 'site-setting'],
            ['category' => 'Setting Management', 'name' => 'email-setting'],
            ['category' => 'Setting Management', 'name' => 'plugin-setting'],
            ['category' => 'Setting Management', 'name' => 'language-setting'],
            ['category' => 'Setting Management', 'name' => 'page-setting'],
            ['category' => 'Setting Management', 'name' => 'sms-setting'],
            ['category' => 'Setting Management', 'name' => 'push-notification-setting'],
            ['category' => 'Setting Management', 'name' => 'notification-tune-setting'],

            ['category' => 'Template Management', 'name' => 'sms-template'],
            ['category' => 'Template Management', 'name' => 'email-template'],
            ['category' => 'Template Management', 'name' => 'push-notification-template'],

            ['category' => 'System Management', 'name' => 'manage-cron-job'],
            ['category' => 'System Management', 'name' => 'cron-job-create'],
            ['category' => 'System Management', 'name' => 'cron-job-edit'],
            ['category' => 'System Management', 'name' => 'cron-job-delete'],
            ['category' => 'System Management', 'name' => 'cron-job-logs'],
            ['category' => 'System Management', 'name' => 'cron-job-run'],
            ['category' => 'System Management', 'name' => 'clear-cache'],
            ['category' => 'System Management', 'name' => 'application-details'],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['guard_name' => 'admin', 'name' => $permission['name'], 'category' => $permission['category']]);
        }
    }
}
