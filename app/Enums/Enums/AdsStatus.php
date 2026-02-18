<?php

namespace App\Enums;

enum AdsStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Pending = 'pending';
    case Rejected = 'rejected';
}
