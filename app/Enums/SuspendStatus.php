<?php

namespace App\Enums;

enum SuspendStatus: string
{
    case ACTIVE = 'ACTIVE';
    case SUSPENDED = 'SUSPENDED';
}