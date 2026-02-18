<?php

namespace App\Enums;

enum AdsType: string
{
    case Link = 'link';
    case Script = 'script';
    case Image = 'image';
    case Youtube = 'youtube';
}
