<?php

namespace App\Enums;

enum WithdrawMethod: string
{
    case INVEST = 'invest';
    case BONUS = 'bonus';
    case PROFIT = 'profit';
    case DREAM = 'dream';
}