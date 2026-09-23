<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'tb_mahasiswa';
    protected $primaryKey = 'nim';
    protected $fillable = [
        'nama',
        'kontak',
        'email',
        'kelamin',
        'img'
    ];
    public $timestamps = false;
}
