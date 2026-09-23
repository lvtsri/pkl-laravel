<?php

namespace App\Http\Controllers\Admin;

use App\Models\Akademik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AkademikController extends Controller
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

        $akademik = Akademik::all();
        return view('admin.akademik.index', compact('akademik') + ['hal' => 'data_akademik']);
    }
}
