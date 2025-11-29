<?php

namespace App\Models;

use App\Enums\JoinMethod;
use App\Enums\JoinStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Join extends Model
{
    use HasFactory;

    protected $table = 'wt_join';
    protected $primaryKey = 'id_join';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_join',
        'id_user',
        'id_prog',
        'nominal_join',
        'insurance',
        'kode_unik',
        'total_bayar',
        'tgl_join',
        'status_join',
        'method',
        'note',
        'wd_status',
    ];

    protected $casts = [
        'nominal_join' => 'float',
        'insurance' => 'float',
        'total_bayar' => 'float',
        'kode_unik' => 'integer',
        'tgl_join' => 'datetime',
        'status_join' => JoinStatus::class,
        'method' => JoinMethod::class,
        'wd_status' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_prog', 'id_prog');
    }
}