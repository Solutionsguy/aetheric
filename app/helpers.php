<?php

use App\Enums\AdsStatus;
use App\Enums\KYCStatus;
use App\Enums\PlanHistoryStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Models\Ads;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\PlanHistory;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

if (! function_exists('isActive')) {
    function isActive($route, $parameter = null, $classForArr = 'show')
    {

        if ($parameter != null && request()->url() === route($route, $parameter)) {
            return 'active';
        }
        if ($parameter == null && is_array($route)) {
            foreach ($route as $value) {
                if (Request::routeIs($value)) {
                    return $classForArr;
                }
            }
        }

        if ($parameter == null && Request::routeIs($route)) {
            return 'active';
        }
    }
}

if (! function_exists('tnotify')) {
    function tnotify($type, $message)
    {
        session()->flash('tnotify', [
            'type' => $type,
            'message' => $message,
        ]);
    }
}

if (! function_exists('setting')) {
    function setting($key, $section = null, $default = null)
    {
        if (is_null($key)) {
            return new \App\Models\Setting();
        }

        if (is_array($key)) {

            return \App\Models\Setting::set($key[0], $key[1]);
        }

        $value = \App\Models\Setting::get($key, $section, $default);

        return is_null($value) ? value($default) : $value;
    }
}

if (! function_exists('oldSetting')) {

    function oldSetting($field, $section)
    {
        return old($field, setting($field, $section));
    }
}

if (! function_exists('settingValue')) {

    function settingValue($field)
    {
        return \App\Models\Setting::get($field);
    }
}

if (! function_exists('getPageSetting')) {

    function getPageSetting($key)
    {
        return \App\Models\PageSetting::where('key', $key)->first()?->value;
    }
}

if (! function_exists('curl_get_file_contents')) {

    function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) {
            return $contents;
        }

        return false;
    }
}

if (! function_exists('getCountries')) {

    function getCountries()
    {
        return json_decode(file_get_contents(resource_path().'/json/CountryCodes.json'), true);
    }
}

if (! function_exists('getCurrency')) {

    function getCurrency($countryName)
    {
        $currencies = json_decode(getJsonData('currency'), true)['fiat'];
        $currency = collect($currencies)->filter(function ($value) use ($countryName) {
            return str_contains($value['text'], $countryName);
        })->value('id', '');

        return $currency;
    }
}

if (! function_exists('getJsonData')) {

    function getJsonData($fileName)
    {
        return file_get_contents(resource_path()."/json/$fileName.json");
    }
}

if (! function_exists('getTimezone')) {
    function getTimezone()
    {
        $timeZones = json_decode(file_get_contents(resource_path().'/json/timeZone.json'), true);

        return array_values(Arr::sort($timeZones, function ($value) {
            return $value['name'];
        }));
    }
}

if (! function_exists('getIpAddress')) {
    function getIpAddress()
    {
        return request()->ip();
    }
}

if (! function_exists('getLocation')) {
    function getLocation()
    {
        $clientIp = request()->ip();
        $ip = $clientIp == '127.0.0.1' ? '103.77.188.202' : $clientIp;

        $location = json_decode(curl_get_file_contents('http://ip-api.com/json/'.$ip), true);

        $currentCountry = collect(getCountries())->first(function ($value, $key) use ($location) {
            return $value['code'] == $location['countryCode'];
        });
        $location = [
            'country_code' => data_get($currentCountry, 'code', 0),
            'name' => $currentCountry['name'],
            'dial_code' => $currentCountry['dial_code'],
            'ip' => $location['query'] ?? [],
        ];

        return new \Illuminate\Support\Fluent($location);
    }
}

if (! function_exists('gateway_info')) {
    function gateway_info($code)
    {
        $info = Gateway::where('gateway_code', $code)->first();

        return json_decode($info->credentials);
    }
}

if (! function_exists('plugin_active')) {
    function plugin_active($name)
    {
        $plugin = \App\Models\Plugin::where('name', $name)->where('status', true)->first();

        return $plugin;
    }
}

if (! function_exists('get_navigation_name')) {
    function get_navigation_name($type)
    {
        $navigation = \App\Models\UserNavigation::where('type', $type)->first();

        return $navigation->name ?? '';
    }
}

if (! function_exists('default_plugin')) {
    function default_plugin($type)
    {
        return \App\Models\Plugin::where('type', $type)->where('status', 1)->first('name')?->name;
    }
}

if (! function_exists('br2nl')) {
    function br2nl($input)
    {
        return preg_replace('/<br\\s*?\/??>/i', '', $input);
    }
}

if (! function_exists('safe')) {
    function safe($input)
    {
        if (! env('APP_DEMO', false)) {
            return $input;
        }

        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {

            $emailParts = explode('@', $input);
            $username = $emailParts[0];
            $hiddenUsername = substr($username, 0, 2).str_repeat('*', strlen($username) - 2);
            $hiddenEmailDomain = substr($emailParts[1], 0, 2).str_repeat('*', strlen($emailParts[1]) - 3).$emailParts[1][strlen($emailParts[1]) - 1];

            return $hiddenUsername.'@'.$hiddenEmailDomain;
        }

        return preg_replace('/(\d{3})\d{3}(\d{3})/', '$1****$2', $input);
    }
}

if (! function_exists('creditReferralBonus')) {
    function creditReferralBonus($user, $type, $mainAmount, $level = null, $depth = 1, $fromUser = null)
    {
        $LevelReferral = \App\Models\LevelReferral::where('type', $type)->where('the_order', $depth)->first('bounty');

        if ($user->ref_id !== null && $depth <= $level && $LevelReferral) {
            $referrer = \App\Models\User::find($user->ref_id);

            $bounty = $LevelReferral->bounty;
            $amount = (float) ($mainAmount * $bounty) / 100;

            $fromUserReferral = $fromUser == null ? $user : $fromUser;

            $description = ucwords($type).' Referral Bonus Via '.$fromUserReferral->full_name.' - Level '.$depth;

            (new Txn)->new($amount, 0, $amount, 'System', $description, TxnType::Referral, TxnStatus::Success, null, null, $referrer->id, $fromUserReferral->id, 'User', [], 'none', $depth, $type, true);

            $referrer->balance += $amount;
            $referrer->save();
            creditReferralBonus($referrer, $type, $mainAmount, $level, $depth + 1, $user);
        }
    }
}

if (! function_exists('getReferralLevel')) {
    function getReferralLevel($user_id = null)
    {
        // Get the user
        $user_id = $user_id ?? auth()->id();

        // Get the plan level
        $planLevel = PlanHistory::where('user_id', $user_id)->where('status', PlanHistoryStatus::ACTIVE)->max('referral_level');

        // If no active plan, get the default level from settings
        if (is_null($planLevel)) {
            $planLevel = (int) setting('referral_level_free_user', 'ads');
        }

        return $planLevel + 1;
    }
}

if (! function_exists('is_custom_rate')) {
    function is_custom_rate($gateway_code)
    {
        if (in_array($gateway_code, ['nowpayments', 'coinremitter', 'blockchain'])) {
            return 'USD';
        }

        return null;
    }
}

if (! function_exists('site_theme')) {
    function site_theme()
    {
        $theme = new \App\Models\Theme();

        return $theme->active();
    }
}
if (! function_exists('generate_date_range_array')) {
    function generate_date_range_array($startDate, $endDate): array
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        $dates = collect([]);

        while ($startDate->lte($endDate)) {
            $dates->push($startDate->format('d M'));
            $startDate->addDay();
        }

        return $dates->toArray();
    }
}
if (! function_exists('calPercentage')) {
    function calPercentage($num, $percentage)
    {
        return $num * ($percentage / 100);
    }
}
if (! function_exists('getQRCode')) {
    function getQRCode($data)
    {

        return "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=$data";
    }
}

if (! function_exists('pending_count')) {
    function pending_count()
    {
        $withdrawCount = Transaction::where('type', TxnType::Withdraw)
            ->where('status', TxnStatus::Pending)
            ->count();

        $kycCount = User::where('kyc', KYCStatus::Pending)->count();

        $pendingAds = Ads::where('status', AdsStatus::Pending)->count();

        $depositCount = Transaction::whereIn('type', [TxnType::ManualDeposit, TxnType::PlanPurchased])
            ->where('status', TxnStatus::Pending)
            ->count();

        $ticketCount = Ticket::where('status', 'open')->count();

        $data = [
            'withdraw_count' => $withdrawCount,
            'kyc_count' => $kycCount,
            'deposit_count' => $depositCount,
            'ticket_count' => $ticketCount,
            'pending_ads' => $pendingAds,
        ];

        return $data;
    }
}

if (! function_exists('content_exists')) {
    function content_exists($url)
    {
        return file_exists(base_path('assets/'.$url));
    }
}

if (! function_exists('grettings')) {
    function grettings()
    {
        $currentHour = date('G');

        if ($currentHour >= 5 && $currentHour < 11) {
            $greeting = 'Good Morning';
        } elseif ($currentHour >= 11 && $currentHour < 14) {
            $greeting = 'Good Noon';
        } elseif ($currentHour >= 14 && $currentHour < 18) {
            $greeting = 'Good Afternoon';
        } elseif ($currentHour >= 18 && $currentHour < 24) {
            $greeting = 'Good Evening';
        } else {
            $greeting = 'Good Evening';
        }

        return $greeting;
    }
}

if (! function_exists('nextInstallment')) {
    function nextInstallment($id, $model, $conditionField)
    {
        $trx = $model::where($conditionField, $id)->where('given_date', null)->first();

        return $trx !== null ? date('d M Y', strtotime($trx->installment_date)) : '--';
    }
}

if (! function_exists('defaultLocale')) {
    function defaultLocale()
    {
        $language = Language::where('is_default', true)->first();

        return $language->locale ?? 'en';
    }
}

if (! function_exists('localeName')) {
    function localeName()
    {
        return Language::where('locale', App::currentLocale())->first()?->name;
    }
}

if (! function_exists('getLandingData')) {
    function getLandingData($code, $status = true)
    {
        $data = \App\Models\LandingPage::where('locale', app()->getLocale())->where('status', $status)->where('code', $code)->first();

        return $data;
    }
}

if (! function_exists('isRtl')) {
    function isRtl($code)
    {
        $language = Language::where('locale', $code)->first();

        return $language->is_rtl ?? false;
    }
}

if (! function_exists('isPlusTransaction')) {
    function isPlusTransaction($type)
    {
        if (
            $type == TxnType::Subtract || $type == TxnType::FundTransfer ||
            $type == TxnType::Withdraw || $type == TxnType::WithdrawAuto
        ) {
            return false;
        }

        return true;
    }
}

if (! function_exists('getTotalMature')) {
    function getTotalMature($dps)
    {
        $totalInstallmentFee = $dps->transactions->sum('paid_amount');

        $interestAmount = ($totalInstallmentFee * $dps->plan?->interest_rate) / 100;

        return intval($totalInstallmentFee + $interestAmount);
    }
}

if (! function_exists('getBrowser')) {

    function getBrowser($user_agent = null)
    {

        $user_agent = $user_agent != null ? $user_agent : request()->userAgent();

        $browser = 'Unknown';
        $platform = 'Unknown';

        if (preg_match('/linux/i', $user_agent)) {
            $platform = 'Linux';
        } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
            $platform = 'Mac';
        } elseif (preg_match('/windows|win32/i', $user_agent)) {
            $platform = 'Windows';
        } elseif (preg_match('/windows|win32/i', $user_agent)) {
            $platform = 'Windows';
        }

        if (preg_match('/MSIE/i', $user_agent) && ! preg_match('/Opera/i', $user_agent)) {
            $browser = 'IE';
        } elseif (preg_match('/Firefox/i', $user_agent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/OPR/i', $user_agent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Chrome/i', $user_agent) && ! preg_match('/Edge/i', $user_agent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $user_agent) && ! preg_match('/Edge/i', $user_agent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Netscape/i', $user_agent)) {
            $browser = 'Netscape';
        } elseif (preg_match('/Edge/i', $user_agent)) {
            $browser = 'Edge';
        } elseif (preg_match('/Trident/i', $user_agent)) {
            $browser = 'IE';
        }

        return [
            'browser' => $browser,
            'platform' => $platform,
        ];
    }
}

if (! function_exists('mySqlVersion')) {
    function mySqlVersion()
    {
        $pdo = DB::connection()->getPdo();
        $version = $pdo->query('select version()')->fetchColumn();

        preg_match("/^[0-9\.]+/", $version, $match);

        $version = $match[0];

        return $version;
    }
}

if (! function_exists('notify')) {
    function notify(?string $message = null, ?string $title = null)
    {
        $notify = app('notify');

        if (! is_null($message)) {
            return $notify->success($message, $title);
        }

        return $notify;
    }
}

if (! function_exists('getTransactionIcon')) {
    function getTransactionIcon($type)
    {
        return match ($type) {
            TxnType::Deposit || TxnType::ManualDeposit => '<i class="icon-dollar-square"></i>',
            TxnType::Withdraw || TxnType::WithdrawAuto => '<i class="icon-money-send"></i>',
            TxnType::FundTransfer => '<i class="icon-repeat-circle"></i>',
            TxnType::ReceivedMoney => '<i class="icon-money-recive"></i>',
            TxnType::Refund => '<i class="icon-money-change"></i>',
            TxnType::PlanPurchased => '<i class="icon-crown"></i>',
            TxnType::Referral => '<i class="icon-profile-2user"></i>',
            TxnType::SignupBonus => '<i class="icon-gift"></i>',
            TxnType::Subtract => '<i class="icon-money-remove"></i>',
            TxnType::AdsPosted => '<i class="icon-tag-user"></i>',
            TxnType::AdsViewed => '<i class="icon-monitor"></i>',
            default => '<i class="icon-arrange-square"></i>'
        };
    }
}
