<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordController extends Controller
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
        return view('admin.password.index', ['hal' => 'password']);
    }
}
