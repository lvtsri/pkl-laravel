<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function index(){
        return view('dosen.password.index', [
            'hal' => 'password',
        ]);
    }
}
