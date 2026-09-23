<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Makul extends Model
{
    protected $table = 'tb_makul';
    protected $primaryKey = 'kode_makul';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'kode_makul',
        'nama_makul',
        'jml_sks',
        'jml_cpmk'
    ];
    public $timestamps = false;
}
