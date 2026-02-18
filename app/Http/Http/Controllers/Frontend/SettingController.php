<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\ImageUpload;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class SettingController extends Controller
{
    use ImageUpload;

    public function settings()
    {
        return view('frontend::user.setting.index');
    }

    public function profileUpdate(Request $request)
    {
        $input = $request->all();

        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
            'gender' => 'required',
            'date_of_birth' => 'date',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $data = [
            'avatar' => $request->hasFile('avatar') ? self::imageUploadTrait($input['avatar'], $user->avatar) : $user->avatar,
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'username' => $input['username'],
            'gender' => $input['gender'],
            'date_of_birth' => $input['date_of_birth'] == '' ? null : $input['date_of_birth'],
            'phone' => $input['phone'],
            'city' => $input['city'],
            'zip_code' => $input['zip_code'],
            'address' => $input['address'],
        ];

        $user->update($data);

        notify()->success(__('Profile updated successfully'), 'Success');

        return redirect()->route('user.setting.show');

    }

    public function twoFa()
    {
        $user = auth()->user();

        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();

        $user->update([
            'google2fa_secret' => $secret,
        ]);

        notify()->success(__('QR Code and Secret Key generate successfully'), 'Success');

        return redirect()->back();
    }

    public function actionTwoFa(Request $request)
    {
        $user = auth()->user();

        if ($request->status == 'disable') {

            if (Hash::check(request('one_time_password'), $user->password)) {
                $user->update([
                    'two_fa' => 0,
                ]);

                notify()->success(__('2FA disabled successfully'), 'Success');

                return redirect()->back();
            }

            notify()->warning(__('Your password is wrong!'), 'Error');

            return redirect()->back();

        } elseif ($request->status == 'enable') {
            session([
                config('google2fa.session_var') => [
                    'auth_passed' => false,
                ],
            ]);

            $authenticator = app(Authenticator::class)->boot($request);
            if ($authenticator->isAuthenticated()) {

                $user->update([
                    'two_fa' => 1,
                ]);

                notify()->success(__('2FA enabled successfully'), 'Success');

                return redirect()->back();

            }

            notify()->warning(__('One time key is wrong!'), 'Error');

            return redirect()->back();
        }
    }

    public function closeAccount(Request $request)
    {
        auth()->user()->update([
            'status' => 2,
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withErrors(['msg' => __('Your Account is Closed.')]);
    }
}
