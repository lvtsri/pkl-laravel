<?php

namespace App\Http\Controllers\Admin;

use App\Models\Makul;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MakulController extends Controller
{
    private function ensureAdmin()
    {
        if (session('peran') != 'A') {
            return redirect('/logout')->with('error', 'Anda bukan admin! Akan segera di logout-kan');
        }
        return null;
    }

    public function index()
    {
        if ($res = $this->ensureAdmin()) return $res;

        $makul = Makul::all();
        return view('admin.makul.index', compact('makul') + ['hal' => 'data_makul']);
    }
}
