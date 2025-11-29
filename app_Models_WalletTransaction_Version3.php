<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $table = 'wallet_transactions';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_user',
        'type',
        'direction',
        'amount',
        'reference_type',
        'reference_id',
        'note',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}