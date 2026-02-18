<?php

namespace App\Http\Controllers\Auth;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Events\UserReferred;
use App\Facades\Txn\Txn;
use App\Http\Controllers\Controller;
use App\Models\LoginActivities;
use App\Models\Page;
use App\Models\ReferralLink;
use App\Models\User;
use App\Rules\Recaptcha;
use App\Traits\NotifyTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    use NotifyTrait;

    public function create()
    {
        if (! setting('account_creation', 'permission')) {
            abort('403', 'User registration is closed now');
        }

        $page = Page::where('code', 'registration')->where('locale', app()->getLocale())->first();

        if (! $page) {
            $page = Page::where('code', 'registration')->where('locale', defaultLocale())->first();
        }
        $data = json_decode($page?->data, true);

        $location = getLocation();
        $referralCode = ReferralLink::find(request()->cookie('invite'))?->code;

        return view('frontend::auth.register', compact('location', 'referralCode', 'data'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {

        $isUsername = (bool) getPageSetting('username_validation') && getPageSetting('username_show');
        $isCountry = (bool) getPageSetting('country_validation') && getPageSetting('country_show');
        $isPhone = (bool) getPageSetting('phone_validation') && getPageSetting('phone_show');
        $isGender = (bool) getPageSetting('gender_validation') && getPageSetting('gender_show');
        $isReferralCode = (bool) getPageSetting('referral_code_validation') && getPageSetting('referral_code_show');

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'g-recaptcha-response' => Rule::requiredIf(plugin_active('Google reCaptcha')),
            new Recaptcha(),
            'gender' => [Rule::requiredIf($isGender), 'in:Male,Female,Others'],
            'username' => [Rule::requiredIf($isUsername), 'string', 'max:255', 'unique:users'],
            'country' => [Rule::requiredIf($isCountry), 'string', 'max:255'],
            'phone' => [Rule::requiredIf($isPhone), 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'invite' => [Rule::requiredIf($isReferralCode), 'exists:referral_links,code'],
        ], [
            'invite.required' => __('Referral code field is required.'),
            'invite.exists' => __('Referral code is invalid'),
        ]);

        $location = getLocation();
        $phoneWithCountryCode = explode(':', $request->get('country', ''));
        $phone = data_get($phoneWithCountryCode, '1', $location->dial_code).$request->get('phone');
        $country = $isCountry ? explode(':', $request->get('country'))[0] : $location->name;

        $user = User::create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'gender' => $request->get('gender'),
            'username' => $isUsername ? $request->get('username') : $request->get('first_name').$request->get('last_name').rand(1000, 9999),
            'country' => $country,
            'phone' => $phone,
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $shortcodes = [
            '[[full_name]]' => $request->get('first_name').' '.$request->get('last_name'),
        ];

        // Notify user and admin
        $this->pushNotify('new_user', $shortcodes, route('admin.user.edit', $user->id), $user->id, 'Admin');
        $this->pushNotify('new_user', $shortcodes, null, $user->id);
        $this->smsNotify('new_user', $shortcodes, $user->phone);

        // Referred event
        event(new UserReferred($request->cookie('invite'), $user));

        if (setting('referral_signup_bonus', 'permission') && (float) setting('signup_bonus', 'fee') > 0) {
            $signupBonus = (float) setting('signup_bonus', 'fee');
            $user->increment('balance', $signupBonus);
            (new Txn)->new($signupBonus, 0, $signupBonus, 'system', 'Signup Bonus', TxnType::SignupBonus, TxnStatus::Success, null, null, $user->id);
            Session::put('signup_bonus', $signupBonus);
        }

        Cookie::forget('invite');
        Auth::login($user);
        LoginActivities::add();

        return to_route('user.dashboard');
    }
}
