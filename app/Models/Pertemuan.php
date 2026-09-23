<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $table = 'tb_pertemuan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_kelas',
        'tanggal',
        'judul_pertemuan',
        'status_pertemuan',
        'pertemuan_ke'
    ];
    public $timestamps = false;
}
