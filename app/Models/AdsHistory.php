<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AdsHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ads_id', 'plan_id', 'amount', 'claimable_at', 'is_claimed'];

    protected $casts = [
        'claimable_at' => 'datetime',
    ];

    public function scopeUser($query, $id = null)
    {
        return $query->where('user_id', $id ?? auth()->id());
    }

    public function ads()
    {
        return $this->hasOne(Ads::class, 'id', 'ads_id');
    }

    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function calculateClaimPercentage()
    {
        $viewedAt = Carbon::parse($this->created_at);
        $claimableAt = Carbon::parse($this->claimable_at);
        $totalDuration = $claimableAt->diffInSeconds($viewedAt);
        $timePassed = now()->diffInSeconds($viewedAt);

        return $totalDuration > 0 ? number_format(min(($timePassed / $totalDuration) * 100, 100), 2) : 100;
    }
}
