<?php

namespace App\Enums;

enum JoinMethod: string
{
    case MANUAL = 'manual';
    case BONUS = 'bonus';
    case PROFIT = 'profit';
}