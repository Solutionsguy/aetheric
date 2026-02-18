<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsReport extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ads()
    {
        return $this->hasOne(Ads::class, 'id', 'ads_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
