<?php

namespace Database\Seeders;

use App\Models\Gateway;
use DB;
use Illuminate\Database\Seeder;

class GatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gateway::truncate();

        // Test credentials for Paystack
        $paystackCredentials = [
            'public_key' => 'pk_test_8e60e513e47ba5619ac0888c9fac99f2853641fa',
            'secret_key' => 'sk_test_e521a3c6d1c37897092868e02e0ddba8c3f0aa01',
            'merchant_email' => 'learn2222earn@gmail.com',
        ];

        $gateways = [
            [
                'gateway_code' => 'paypal',
                'name' => 'Paypal',
                'logo' => 'global/gateway/paypal.png',
                'supported_currencies' => json_encode(['USD', 'EUR', 'GBP', 'CAD', 'AUD', 'JPY', 'SGD', 'NZD', 'CHF', 'SEK', 'NOK', 'DKK', 'PLN', 'HUF', 'CZK', 'ILS', 'BRL', 'MXN', 'HKD', 'TWD', 'TRY', 'INR', 'RUB', 'ZAR', 'MYR', 'THB', 'IDR', 'PHP', 'NGN', 'GHS']),
                'credentials' => json_encode(['client_id' => '', 'client_secret' => '', 'app_id' => 'APP-80W284485P519543T', 'mode' => 'sandbox']),
                'is_withdraw' => 'paypal_email',
                'status' => true,
            ],
            [
                'gateway_code' => 'stripe',
                'name' => 'Stripe',
                'logo' => 'global/gateway/stripe.png',
                'supported_currencies' => json_encode(['USD', 'AUD', 'BRL', 'CAD', 'CHF', 'DKK', 'EUR', 'GBP', 'HKD', 'INR', 'JPY', 'MXN', 'MYR', 'NOK', 'NZD', 'PLN', 'SEK', 'SGD']),
                'credentials' => json_encode(['stripe_key' => 'pk_test_51KHQhKAmfDlh6wQq4srkOEY3FkivTCXmRSb7bJqr90q3ZkVWAR2AkRWfKBnegpmKAHea5cNVAToiy7yoa3Q075mR00jlhXsZTO', 'stripe_secret' => 'sk_test_51KHQhKAmfDlh6wQqXfg4ZScnTRahxbdXV0mKw30nOI4f8gtB2v5rho7IyJtZqkf8SwwuNgLTO2WPGFyk9vnFl8gO00MhSe8Kbj']),
                'is_withdraw' => '0',
                'status' => true,
            ],
            [
                'gateway_code' => 'mollie',
                'name' => 'Mollie',
                'logo' => 'global/gateway/mollie.png',
                'supported_currencies' => json_encode(['EUR', 'USD', 'GBP', 'CAD', 'AUD', 'CHF', 'DKK', 'NOK', 'SEK', 'PLN', 'CZK', 'HUF', 'RON', 'BGN', 'HRK', 'ISK', 'ZAR']),
                'credentials' => json_encode(['api_key' => 'test_intSTCDEBaDSu28D6DUpn5wnQhTnzB']),
                'is_withdraw' => '0',
                'status' => true,
            ],
            [
                'gateway_code' => 'perfectmoney',
                'name' => 'Perfect Money',
                'logo' => 'global/gateway/perfectmoney.png',
                'supported_currencies' => json_encode(['USD', 'EUR', 'RUB', 'UAH']),
                'credentials' => json_encode(['PM_ACCOUNTID' => '96793260', 'PM_PASSPHRASE' => '77887848a', 'PM_MARCHANTID' => 'U36928259', 'PM_MARCHANT_NAME' => 'tdevs']),
                'is_withdraw' => 'member_id',
                'status' => true,
            ],
            [
                'gateway_code' => 'coinbase',
                'name' => 'Coinbase',
                'logo' => 'global/gateway/coinbase.png',
                'supported_currencies' => json_encode(['USD', 'EUR', 'GBP', 'CAD', 'AUD', 'JPY', 'BTC', 'ETH', 'LTC', 'BCH', 'XRP', 'EOS']),
                'credentials' => json_encode(['apiKey' => '', 'account_id' => '', 'private_key' => '', 'webhookSecret' => '', 'apiVersion' => '2018-03-22']),
                'is_withdraw' => 'email_address',
                'status' => true,
            ],
            [
                'gateway_code' => 'paystack',
                'name' => 'Paystack',
                'logo' => 'global/gateway/paystack.png',
                'supported_currencies' => json_encode(['NGN', 'USD', 'GBP', 'EUR', 'GHS', 'KES', 'ZAR', 'UGX', 'TZS', 'RWF']),
                'credentials' => json_encode($paystackCredentials),
                'is_withdraw' => '0',
                'status' => true,
            ],
            [
                'gateway_code' => 'binance',
                'name' => 'Binance',
                'logo' => 'global/gateway/binance.png',
                'supported_currencies' => json_encode(['USDT', 'BTC', 'ETH', 'BUSD']),
                'credentials' => json_encode(['api_key' => '', 'api_secret' => '']),
                'is_withdraw' => '0',
                'status' => true,
            ],
        ];

        foreach ($gateways as $gateway) {
            Gateway::create($gateway);
        }
    }
}
