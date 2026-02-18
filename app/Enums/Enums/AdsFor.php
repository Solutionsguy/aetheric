<?php

namespace App\Enums;

enum AdsFor: string
{
    case FreeUsers = 'free_users';
    case SubscribedUsers = 'subscribed_users';
    case BothUsers = 'both_users';
}
