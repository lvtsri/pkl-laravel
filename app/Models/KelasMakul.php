<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasMakul extends Model
{
    protected $table = 'tb_kelas_makul';
    protected $primaryKey = 'kode_kelas';
    protected $fillable = [
        'kode_akd',
        'kode_makul',
        'kode_jurusan',
        'nik',
        'nama_kelas'
    ];
    public $timestamps = false;

    public function akademik(){
        return $this->belongsTo(Akademik::class, 'kode_akd', 'kode_akd');
    }

    public function makul(){
        return $this->belongsTo(Makul::class, 'kode_makul', 'kode_makul');
    }

    public function jurusan(){
        return $this->belongsTo(Jurusan::class, 'kode_jurusan', 'kode_jurusan');
    }

    public function dosen(){
        return $this->belongsTo(Dosen::class, 'nik', 'nik');
    }
}
