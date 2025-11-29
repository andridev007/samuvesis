<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletBalance extends Model
{
    use HasFactory;

    protected $table = 'wallet_balances';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'remaining_profit',
        'remaining_bonus',
        'referral_bonus_total',
        'share_profit_bonus_total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}