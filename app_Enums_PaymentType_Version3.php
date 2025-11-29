<?php

namespace App\Enums;

enum PaymentType: string
{
    case MANUAL = 'manual';
    case AUTOMATIC = 'automatic';
}