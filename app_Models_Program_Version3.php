<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;

    protected $table = 'wt_program';
    protected $primaryKey = 'id_prog';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_prog',
        'id_group',
        'nama_prog',
        'hrg_prog',
        'min_depo',
        'est_balik',
        'est_terima',
    ];

    protected $casts = [
        'hrg_prog' => 'float',
        'min_depo' => 'float',
        'est_balik' => 'integer',
        'est_terima' => 'integer',
    ];
}