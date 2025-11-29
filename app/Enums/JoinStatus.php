<?php

namespace App\Enums;

enum JoinStatus: string
{
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case ACTIVE = 'active';
    case DONE = 'done';
    case DELETED = 'deleted';
}