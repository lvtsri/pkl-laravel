<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'tb_dosen';
    protected $primaryKey = 'nik';
    protected $fillable = [
        'nama',
        'kontak',
        'email',
        'kelamin',
        'img'
    ];
    public $timestamps = false;
}
