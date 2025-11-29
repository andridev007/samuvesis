<?php

namespace App\Enums;

enum AccStatus: string
{
    case VERIFIED = 'verified';
    case UNVERIFIED = 'unverified';
}