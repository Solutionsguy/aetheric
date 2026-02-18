<?php

namespace App\Models;

use App\Enums\PlanHistoryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanHistory extends Model
{
    use HasFactory;

    public function plan()
    {
        return $this->hasOne(SubscriptionPlan::class, 'id', 'plan_id');
    }

    protected $guarded = ['id'];

    protected $casts = [
        'validity_at' => 'datetime',
        'status' => PlanHistoryStatus::class,
    ];
}
