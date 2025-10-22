<?php

namespace App\Enums;

enum GiftVariant: string
{
    case WITH_SHIPPING = 'with_shipping';
    case WITHOUT_SHIPPING = 'without_shipping';
}
