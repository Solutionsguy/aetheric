<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentPlan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function investments()
    {
        return $this->hasMany(Investment::class, 'plan_id');
    }
}
