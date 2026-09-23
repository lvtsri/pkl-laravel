<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'tb_presensi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_pertemuan',
        'nim',
        'status_kehadiran'
    ];
    public $timestamps = false;
}
