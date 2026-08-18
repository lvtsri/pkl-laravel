<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'tb_pengguna';
    protected $primaryKey = 'id';
    protected $fillable = [
        'username',
        'sandi',
        'peran',
        'pin'
    ];
    public $timestamps = false;
}
