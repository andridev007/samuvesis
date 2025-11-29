<?php

namespace App\Enums;

enum WithdrawStatus: string
{
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case DONE = 'done';
}