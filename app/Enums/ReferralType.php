<?php

namespace App\Enums;

enum ReferralType: string
{
    case NONE = 'none';
    case SELF = 'self';
    case OTHER = 'other';
}
