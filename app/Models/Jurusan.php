<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'tb_jurusan';
    protected $primaryKey = 'kode_jurusan';
    public $incrementing = false;
    public $keyType = 'string';
    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan'
    ];
    public $timestamps = false;
}
