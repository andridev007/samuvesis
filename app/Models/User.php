<?php

namespace App\Models;

use App\Enums\AccStatus;
use App\Enums\SuspendStatus;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'wt_user';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'no_id',
        'username',
        'nama_user',
        'foto_user',
        'email',
        'hp',
        'nama_bank',
        'rek_bank',
        'referral',
        'id_user_referral',
        'acc_status',
        'status_suspend',
        'wd_status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'acc_status' => AccStatus::class,
        'status_suspend' => SuspendStatus::class,
        'wd_status' => 'integer',
    ];

    public function joins()
    {
        return $this->hasMany(Join::class, 'id_user', 'id_user');
    }
}