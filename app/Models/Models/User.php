<?php

namespace App\Models;

use App\Enums\KYCStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use Carbon\Carbon;
use Coderflex\LaravelTicket\Concerns\HasTickets;
use Coderflex\LaravelTicket\Contracts\CanUseTickets;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements CanUseTickets, MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasTickets, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar',
        'first_name',
        'last_name',
        'country',
        'phone',
        'username',
        'email',
        'email_verified_at',
        'gender',
        'date_of_birth',
        'city',
        'zip_code',
        'address',
        'balance',
        'status',
        'kyc',
        'google2fa_secret',
        'two_fa',
        'deposit_status',
        'withdraw_status',
        'transfer_status',
        'otp_status',
        'referral_status',
        'ref_id',
        'password',
        'phone_verified',
        'otp',
        'close_reason',
    ];

    protected $appends = [
        'full_name',
        'kyc_time',
        'kyc_type',
        'total_profit',
        'total_deposit',
        'total_invest',
    ];

    protected $dates = ['kyc_time'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_fa' => 'boolean',
        'phone_verified' => 'boolean',
        'notifications_permission' => 'array',
        'validity_at' => 'datetime',
    ];

    /*
     * Scope Declaration
     * */

    public function scopeSearch($query, $search)
    {
        if ($search != null) {
            return $query->where(function ($query) use ($search) {
                $query->orWhere('first_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('last_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('username', 'LIKE', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%')
                    ->orWhere('phone', 'LIKE', '%'.$search.'%');
            });
        }

        return $query;
    }

    public function getAvatarPathAttribute()
    {
        return $this->avatar != null && file_exists(base_path('assets/'.$this->avatar)) ? asset($this->avatar) : asset('frontend/images/user.jpg');
    }

    public function scopeStatus($query, $status)
    {
        if ($status != 'all' && $status != null) {
            $status = $status == 'pending' ? KYCStatus::Pending : ($status === 'rejected' ? KYCStatus::Failed : KYCStatus::Verified);

            return $query->where('kyc', $status);
        }
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 2);
    }

    public function scopeDisabled($query)
    {
        return $query->where('status', 0);
    }

    public function getUpdatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y h:i A');
    }

    public function getCreatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y h:i A');
    }

    public function getFullNameAttribute(): string
    {
        return ucwords($this->first_name.' '.$this->last_name);
    }

    public function getKycTypeAttribute(): string
    {
        $kycs = UserKyc::where('user_id', $this->attributes['id'])->pluck('kyc_id');

        $types = Kyc::whereIn('id', $kycs)->pluck('name')->implode(',');

        return $types;
    }

    public function getTotalProfitAttribute(): string
    {
        return $this->totalProfit();
    }

    public function getTotalDepositAttribute(): string
    {
        return $this->totalDeposit();
    }

    public function totalProfit($days = null)
    {
        $sum = $this->transaction()->where('status', TxnStatus::Success)->whereIn('type', [TxnType::Referral, TxnType::AdsViewed, TxnType::SignupBonus]);

        if ($days != null) {
            $sum->where('created_at', '>=', Carbon::now()->subDays((int) $days));
        }

        $sum = $sum->sum('amount');

        return round($sum, 2);
    }

    public function rejectedKycs()
    {
        return $this->kycs()->where('status', 'rejected');
    }

    public function kycs()
    {
        return $this->hasMany(UserKyc::class, 'user_id', 'id');
    }

    public function adsHistories()
    {
        return $this->hasMany(AdsHistory::class, 'user_id', 'id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function getReferrals()
    {
        return ReferralProgram::all()->map(function ($program) {
            return ReferralLink::getReferral($this, $program);
        });
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'ref_id');
    }

    public function totalDeposit()
    {
        $sum = $this->transaction()->where('status', TxnStatus::Success)->where(function ($query) {
            $query->where('type', TxnType::Deposit)
                ->orWhere('type', TxnType::ManualDeposit);
        })->sum('amount');

        return round($sum, 2);
    }

    public function totalDepositBonus()
    {
        $sum = $this->transaction()->where('status', TxnStatus::Success)->where(function ($query) {
            $query->where('target_id', '!=', null)
                ->where('target_type', 'deposit')
                ->where('type', TxnType::Referral);
        })->sum('amount');

        return round($sum, 2);
    }

    public function totalWithdraw()
    {
        $sum = $this->transaction()->where('status', TxnStatus::Success)->whereIn('type', [TxnType::Withdraw, TxnType::WithdrawAuto])->sum('amount');

        return round($sum, 2);
    }

    public function totalTransfer()
    {
        $sum = $this->transaction()->where('status', TxnStatus::Success)->where(function ($query) {
            $query->where('type', TxnType::FundTransfer);
        })->sum('amount');

        return round($sum, 2);
    }

    public function totalReferralProfit()
    {
        $sum = $this->transaction()->where('status', TxnStatus::Success)->where(function ($query) {
            $query->where('type', TxnType::Referral);
        })->sum('amount');

        return round($sum, 2);
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }

    protected function google2faSecret(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value != null ? Crypt::decryptString($value) : $value,
            set: fn ($value) => Crypt::encryptString($value),
        );
    }

    public function activities()
    {
        return $this->hasMany(LoginActivities::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function refferelLinks()
    {
        return $this->hasMany(ReferralLink::class);
    }

    public function withdrawAccounts()
    {
        return $this->hasMany(WithdrawAccount::class);
    }
}
