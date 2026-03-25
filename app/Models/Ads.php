<?php

namespace App\Models;

use App\Enums\AdsFor;
use App\Enums\AdsStatus;
use App\Enums\AdsType;
use App\Enums\PlanHistoryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function scopeActive($query)
    {
        return $query->where('status', AdsStatus::Active);
    }

    public function getTypeValueAttribute()
    {
        return match ($this->type) {
            AdsType::Link => __('Link/URL'),
            AdsType::Image => __('Banner/Image'),
            AdsType::Script => __('Script/Code'),
            AdsType::Youtube => __('YouTube'),
        };
    }

    public function getTypeBgAttribute()
    {
        return match ($this->type) {
            AdsType::Link => asset('frontend/default/images/shapes/ads-pattern-2.png'),
            AdsType::Image => asset('frontend/default/images/shapes/ads-pattern.png'),
            AdsType::Script => asset('frontend/default/images/shapes/ads-pattern-3.png'),
            AdsType::Youtube => asset('frontend/default/images/shapes/ads-pattern-4.png'),
            default => asset('frontend/default/images/shapes/ads-pattern.png')
        };
    }

    public function scopeSearch($query, $search)
    {
        if (filled($search)) {
            return $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%'.$search.'%');
            });
        }

        return $query;
    }

    public function scopeType($query, $type)
    {
        if (filled($type) && $type != 'all') {
            return $query->where('type', $type);
        }

        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if (filled($status) && $status != 'all') {
            return $query->where('status', $status);
        }

        return $query;
    }

    protected function scopeForUser($query)
    {
        $isSubscribed = \App\Models\PlanHistory::where('user_id', auth()->id())
            ->where('status', \App\Enums\PlanHistoryStatus::ACTIVE)
            ->exists();

        $for = $isSubscribed ? AdsFor::SubscribedUsers : AdsFor::FreeUsers;

        return $query->whereIn('for', [AdsFor::BothUsers, $for]);
    }

    public function getLastViewedAtAttribute()
    {
        return AdsHistory::where('user_id', auth()->id())->where('ads_id', $this->id)->where('created_at', '>=', now()->subHours(24))->first()->created_at ?? null;
    }

    public function isScheduledNow()
    {
        $currentDay = strtolower(now()->format('l'));
        $currentTime = now()->format('H:i');

        foreach ($this->schedules ?: [] as $schedule) {
            if (strtolower($schedule['day']) === $currentDay) {
                if ($schedule['start_time'] <= $currentTime && $schedule['end_time'] >= $currentTime) {
                    return true;
                }
            }
        }

        return $this->schedules === null ? true : false;
    }

    protected function scopeUser($query, $id = null)
    {
        return $query->where('user_id', $id ?? auth()->id());
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    protected $casts = [
        'type' => AdsType::class,
        'status' => AdsStatus::class,
        'for' => AdsFor::class,
        'schedules' => 'array',
    ];
}
