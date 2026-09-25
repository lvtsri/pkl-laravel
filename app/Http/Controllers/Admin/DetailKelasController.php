<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\DetailKelasMakul;
use Illuminate\Http\Request;

class DetailKelasController extends Controller
{
    public function index(){
        return view('admin.detail_kelas.index', ['hal' => 'data_kelas_makul']);
    }
}
