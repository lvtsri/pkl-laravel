<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DosenExport;
use App\Http\Controllers\Controller;
use App\Imports\DosenImport;
use App\Models\Dosen;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::all();
        return view('admin.dosen.index', compact('dosen') + ['hal' => 'data_dosen']);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'kelamin' => 'required',
        ]);

        $exists = Dosen::where('nik', $request->nik)->exists();

        if ($exists) {
            return redirect()->route('admin.dosen')->with('error', 'NIK sudah terdaftar!');
        }

        Dosen::create([
            'nik' => trim($request->nik),
            'nama' => trim($request->nama),
            'kontak' => trim($request->kontak),
            'email' => trim($request->email),
            'kelamin' => trim($request->kelamin),
        ]);

        Pengguna::create([
            'username' => trim($request->nik),
            'sandi' => sha1(trim($request->nik)),
            'peran' => 'D',
            'pin' => '654321',
            'nama' => trim($request->nama),
        ]);

        return redirect()->route('admin.dosen')->with('success', 'Data dosen telah berhasil ditammbahkan!');
    }

    public function update(Request $request, $nik){
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'kontak' => 'required',
            'email' => 'required',
            'kelamin' => 'required',
        ]);

        $dosen = Dosen::where('nik', $nik)->first();

        if (!$dosen) {
            return redirect()->route('admin.dosen')->with('error', 'Data dosen tidak valid!');
        }

        $dosen->update([
            'nama' => trim ($request->nama),
            'kontak' => trim ($request->kontak),
            'email' => trim ($request->email),
            'kelamin' => trim ($request->kelamin),
        ]);
        
        return redirect()->route('admin.dosen')->with('success', 'Data dosen telah berhasil diubah!');
    }

    public function ubahFoto(Request $request, $nik){
        $dosen = Dosen::findOrFail($nik);
        
        if ($request->hasFile('foto_dosen')) {
            // Hapus foto lama dari disk
            if ($dosen->img && !str_contains($dosen->img, '../') && Storage::disk('public')->exists($dosen->img)) {
                Storage::disk('public')->delete($dosen->img);
            }
            // Upload foto baru ke folder images di disk public
            $path = $request->file('foto_dosen')->store('images', 'public');
            $dosen->img = $path;
        }
        $dosen->update($request->except('foto_dosen'));
        
        return redirect()->route('admin.dosen')->with('success', 'Data dosen telah berhasil diubah!');
    }

    public function destroy($nik){
        $dosen = Dosen::where('nik', $nik)->first();

        if (!$dosen) {
            return redirect()->route('admin.dosen')->with('error', 'Data dosen tidak valid!');
        }

        try {
            $dosen->delete();
            return redirect()->route('admin.dosen')->with('success', 'Data dosen telah dihapus!');
        } catch (\Throwable $th) {
            return redirect()->route('admin.dosen')->with('error', 'Gagal menghapus data dosen');
        }
    }

    // ` PDF `
    public function exportPdf()
    {
        $dosen = Dosen::get();
    
        $data = [
            'title' => 'Data Dosen',
            // 'date' => date('m/d/Y'),
            'dosen' => $dosen,
        ]; 
        
        $pdf = Pdf::loadView('admin.dosen.pdf', $data);
    
        // return $pdf->download('data_dosen.pdf');
        return $pdf->stream('data_dosen.pdf');
    }

    // ` EXCEL `
    public function exportExcel(){
        return Excel::download(new DosenExport, 'Data_Dosen.xlsx');
    }

    public function importExcel(Request $request){
        $request->validate([
            'file_excel' => 'required',
        ]);

        Excel::import(new DosenImport, $request->file('file_excel'));
        
        return back()->with('success', 'Data dosen telah berhasil diimpor');
    }
}
