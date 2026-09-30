<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKelasMakul extends Model
{
    protected $table = 'tb_detail_kls_mk';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_kelas',
        'nim'
    ];
    public $timestamps = false;

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
