<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\Frontend\AdsController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\DepositController;
use App\Http\Controllers\Frontend\FundTransferController;
use App\Http\Controllers\Frontend\GatewayController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\IpnController;
use App\Http\Controllers\Frontend\KycController;
use App\Http\Controllers\Frontend\MyAdsController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ReferralController;
use App\Http\Controllers\Frontend\SettingController;
use App\Http\Controllers\Frontend\StatusController;
use App\Http\Controllers\Frontend\SubscriptionController;
use App\Http\Controllers\Frontend\TicketController;
use App\Http\Controllers\Frontend\TransactionController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\WithdrawController;
use App\Http\Controllers\UpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::post('subscriber', [HomeController::class, 'subscribeNow'])->name('subscriber');

//Dynamic Page
Route::get('page/{section}', [PageController::class, 'getPage'])->name('dynamic.page');

Route::get('blog/{id}', [PageController::class, 'blogDetails'])->name('blog-details');
Route::post('mail-send', [PageController::class, 'mailSend'])->name('mail-send');

// User Part
Route::group(['middleware' => ['auth', '2fa', 'isActive', setting('otp_verification', 'permission') ? 'otp' : 'web', setting('email_verification', 'permission') ? 'verified' : 'web'], 'prefix' => 'user', 'as' => 'user.'], function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Subscription
    Route::prefix('subscriptions')->controller(SubscriptionController::class)->group(function () {
        Route::get('/', 'index')->name('subscriptions');
        Route::get('/history', 'history')->name('subscriptions.history');
        Route::get('/purchase/{plan}', 'purchasePreview')->name('subscription.purchase.preview');
        Route::post('/subscription-now', 'subscriptionNow')->name('subscription.now');
    });

    // Ads
    Route::prefix('ads')->name('ads.')->controller(AdsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/ads/{plan}', 'adsView')->name('view');
        Route::post('/ads-submit/{id}', 'adsSubmit')->name('submit');
        Route::post('/report-submit/{id}', 'reportSubmit')->name('report.submit');
    });

    // My Ads
    Route::prefix('my-ads')->name('my.ads.')->controller(MyAdsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create-ads', 'create')->name('create');
        Route::get('/edit-ads/{id}', 'edit')->name('edit');
        Route::post('/store-ads', 'store')->name('store');
        Route::post('/update-ads/{id}', 'update')->name('update');
    });

    // Earnings
    Route::get('earnings', [UserController::class, 'myEarnings'])->name('my.earnings');

    // Email check
    Route::get('exist/{email}', [UserController::class, 'userExist'])->name('exist');

    // User Notify
    Route::get('notify', [UserController::class, 'notifyUser'])->name('notify');
    Route::get('notification/all', [UserController::class, 'allNotification'])->name('notification.all');
    Route::get('latest-notification', [UserController::class, 'latestNotification'])->name('latest-notification');
    Route::get('notification-read/{id}', [UserController::class, 'readNotification'])->name('read-notification');

    // Change Password
    Route::get('/change-password', [UserController::class, 'changePassword'])->name('change.password');
    Route::post('/password-store', [UserController::class, 'newPassword'])->name('new.password');

    // KYC Apply
    Route::get('kyc', [KycController::class, 'kyc'])->name('kyc');
    Route::get('kyc-details', [KycController::class, 'kycDetails'])->name('kyc.details');
    Route::get('kyc/submission/{id}', [KycController::class, 'kycSubmission'])->name('kyc.submission');
    Route::get('kyc/{id}', [KycController::class, 'kycData'])->name('kyc.data');
    Route::post('kyc-submit', [KycController::class, 'submit'])->name('kyc.submit');

    // Transactions
    Route::get('transactions', [TransactionController::class, 'transactions'])->name('transactions');

    // Deposit
    Route::group(['prefix' => 'deposit', 'as' => 'deposit.'], function () {
        Route::get('', [DepositController::class, 'deposit'])->name('amount');
        Route::get('gateway/{code}', [GatewayController::class, 'gateway'])->name('gateway');
        Route::post('now', [DepositController::class, 'depositNow'])->name('now');
        Route::get('success', [DepositController::class, 'depositSuccess'])->name('success');
        Route::get('log', [DepositController::class, 'depositLog'])->name('log');
    });

    // Fund Transfer
    Route::group(['prefix' => 'fund-transfer', 'as' => 'fund_transfer.'], function () {
        Route::get('/', [FundTransferController::class, 'index'])->name('index');
        Route::get('/history', [FundTransferController::class, 'history'])->name('history');
        Route::post('transfer', [FundTransferController::class, 'transfer'])->name('transfer');
    });

    // Withdraw
    Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.', 'controller' => WithdrawController::class], function () {

        // Withdraw Account
        Route::resource('account', WithdrawController::class)->except('show');
        Route::post('account/delete/{id}', [WithdrawController::class, 'delete'])->name('account.delete');

        // Withdraw
        Route::get('/', 'withdraw')->name('view');
        Route::get('details/{accountId}/{amount?}', 'details')->name('details');
        Route::get('method/{id}', 'withdrawMethod')->name('method');
        Route::post('now', 'withdrawNow')->name('now');
        Route::get('log', 'withdrawLog')->name('log');
    });

    // Support ticket
    Route::group(['prefix' => 'support-ticket', 'as' => 'ticket.', 'controller' => TicketController::class], function () {
        Route::get('index', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::post('reply', 'reply')->name('reply');
        Route::get('show/{uuid}', 'show')->name('show');
        Route::get('close-now/{uuid}', 'closeNow')->name('close.now');
    });

    // Referral
    Route::get('referral', [ReferralController::class, 'referral'])->name('referral');
    Route::get('referral/tree', [ReferralController::class, 'referralTree'])->name('referral.tree');

    // Settings
    Route::group(['prefix' => 'settings', 'as' => 'setting.', 'controller' => SettingController::class], function () {
        Route::get('/', 'settings')->name('show');
        Route::get('2fa', 'twoFa')->name('2fa');
        Route::get('action', 'action')->name('action');
        Route::post('action-2fa', 'actionTwoFa')->name('action-2fa');
        Route::post('profile-update', 'profileUpdate')->name('profile-update');
        Route::post('close-account', 'closeAccount')->name('close.account');

        Route::post('/2fa/verify', function () {
            return redirect(route('user.dashboard'));
        })->name('2fa.verify');
    });
});

// Translate
Route::get('language-update', [HomeController::class, 'languageUpdate'])->name('language-update');

// Gateway Manage
Route::get('gateway-list', [GatewayController::class, 'gatewayList'])->name('gateway.list')->middleware('XSS', 'translate', 'auth');

// Gateway status
Route::group(['controller' => StatusController::class, 'prefix' => 'status', 'as' => 'status.'], function () {
    Route::match(['get', 'post'], '/success', 'success')->name('success');
    Route::match(['get', 'post'], '/cancel', 'cancel')->name('cancel');
    Route::match(['get', 'post'], '/pending', 'pending')->name('pending');
});

// Instant payment notification
Route::group(['prefix' => 'ipn', 'as' => 'ipn.', 'controller' => IpnController::class], function () {
    Route::post('coinpayments', 'coinpaymentsIpn')->name('coinpayments');
    Route::post('nowpayments', 'nowpaymentsIpn')->name('nowpayments');
    Route::post('cryptomus', 'cryptomusIpn')->name('cryptomus');
    Route::get('paypal', 'paypalIpn')->name('paypal');
    Route::post('mollie', 'mollieIpn')->name('mollie');
    Route::any('perfectmoney', 'perfectMoneyIpn')->name('perfectMoney');
    Route::get('paystack', 'paystackIpn')->name('paystack');
    Route::get('flutterwave', 'flutterwaveIpn')->name('flutterwave');
    Route::post('coingate', 'coingateIpn')->name('coingate');
    Route::get('monnify', 'monnifyIpn')->name('monnify');
    Route::get('non-hosted-securionpay', 'nonHostedSecurionpayIpn')->name('non-hosted.securionpay')->middleware(['auth', 'XSS']);
    Route::post('coinremitter', 'coinremitterIpn')->name('coinremitter');
    Route::post('btcpay', 'btcpayIpn')->name('btcpay');
    Route::post('binance', 'binanceIpn')->name('binance');
    Route::get('blockchain', 'blockchainIpn')->name('blockchain');
    Route::get('instamojo', 'instamojoIpn')->name('instamojo');
    Route::post('paytm', 'paytmIpn')->name('paytm');
    Route::post('razorpay', 'razorpayIpn')->name('razorpay');
    Route::post('twocheckout', 'twocheckoutIpn')->name('twocheckout');
});

// Site others
Route::get('theme-mode', [HomeController::class, 'themeMode'])->name('mode-theme');
Route::get('refresh-token', [HomeController::class, 'refreshToken']);

// Without auth
Route::get('notification-tune', [AppController::class, 'notificationTune'])->name('notification-tune');

// Site cron job
Route::get('site-cron', [CronJobController::class, 'runCronJobs'])->name('cron.job');

// Update System
Route::get('update', UpdateController::class)->middleware(['web', 'auth:admin', 'XSS', 'isDemo', 'trans', 'install_check'])->name('update');
