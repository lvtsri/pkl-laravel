<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class PertemuanController extends Controller
{
    public function index(){
        return view('admin.kelas_makul.pertemuan', ['hal' => 'data_kelas_makul']);
    }
}
