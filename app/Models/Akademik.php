<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akademik extends Model
{
    protected $table = 'tb_akademik';
    protected $primaryKey = 'kode_akd';
    protected $fillable = [
        'kode_akd',
        'semester',
        'tahun',
        'is_active'
    ];
    public $timestamps = false;
}
