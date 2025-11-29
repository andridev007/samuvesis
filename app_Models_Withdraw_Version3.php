<?php

namespace App\Models;

use App\Enums\PaymentType;
use App\Enums\WithdrawMethod;
use App\Enums\WithdrawStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdraw extends Model
{
    use HasFactory;

    protected $table = 'wt_withdraw';
    protected $primaryKey = 'id_wd';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_wd',
        'id_user',
        'nominal_wd',
        'wd_diterima',
        'fee_wd',
        'tgl_wd',
        'status_wd',
        'method',
        'payment',
    ];

    protected $casts = [
        'nominal_wd' => 'float',
        'wd_diterima' => 'float',
        'fee_wd' => 'float',
        'tgl_wd' => 'datetime',
        'status_wd' => WithdrawStatus::class,
        'method' => WithdrawMethod::class,
        'payment' => PaymentType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}