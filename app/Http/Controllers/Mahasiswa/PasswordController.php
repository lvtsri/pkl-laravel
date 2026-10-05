<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function index(){
        return view('mahasiswa.password.index', [
            'hal' => 'password',
        ]);
    }
}
