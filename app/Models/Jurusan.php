<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'tb_jurusan';
    protected $primaryKey = 'kode_jurusan';
    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan'
    ];
    public $timestamps = false;
}
