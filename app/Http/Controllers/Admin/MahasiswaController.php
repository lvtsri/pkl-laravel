<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MahasiswaExport;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function index() {
        $mahasiswa = Mahasiswa::all();
        return view('admin.mahasiswa.index', compact('mahasiswa') + ['hal' => 'data_mahasiswa']);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kelamin' => 'required',
        ]);

        $exists = Mahasiswa::where('nim', $request->nim)->exists();

        if ($exists) {
            return redirect()->route('admin.mahasiswa')->with('error', 'nim sudah terdaftar!');
        }

        Mahasiswa::create([
            'nim' => trim($request->nim),
            'nama' => trim($request->nama),
            'kontak' => trim($request->kontak),
            'email' => trim($request->email),
            'kelamin' => trim($request->kelamin),
        ]);

        Pengguna::create([
            'username' => trim($request->nim),
            'sandi' => sha1(trim($request->nim)),
            'peran' => 'M',
            'pin' => '111111',
            'nama' => trim($request->nama),
        ]);

        return redirect()->route('admin.mahasiswa')->with('success', 'Data mahasiswa telah berhasil ditammbahkan!');
    }

    public function update(Request $request, $nim){
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kontak' => 'required',
            'email' => 'required',
            'kelamin' => 'required',
        ]);

        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return redirect()->route('admin.mahasiswa')->with('error', 'Data mahasiswa tidak valid!');
        }

        $mahasiswa->update([
            'nama' => trim ($request->nama),
            'kontak' => trim ($request->kontak),
            'email' => trim ($request->email),
            'kelamin' => trim ($request->kelamin),
        ]);

        return redirect()->route('admin.mahasiswa')->with('success', 'Data mahasiswa telah berhasil diubah!');
    }
    
    public function ubahFoto(Request $request, $nim){
        $mahasiswa = Mahasiswa::findOrFail($nim);
        
        if ($request->hasFile('foto_mhs')) {
            // Hapus foto lama dari disk
            if ($mahasiswa->img && !str_contains($mahasiswa->img, '../') && Storage::disk('public')->exists($mahasiswa->img)) {
                Storage::disk('public')->delete($mahasiswa->img);
            }
            // Upload foto baru ke folder images di disk public
            $path = $request->file('foto_mhs')->store('images', 'public');
            $mahasiswa->img = $path;
        }
        $mahasiswa->update($request->except('foto_mhs'));
        
        return redirect()->route('admin.mahasiswa')->with('success', 'Data mahasiswa telah berhasil diubah!');
    }

    public function destroy($nim){
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return redirect()->route('admin.mahasiswa')->with('error', 'Data mahasiswa tidak valid!');
        }

        try {
            $mahasiswa->delete();
            return redirect()->route('admin.mahasiswa')->with('success', 'Data mahasiswa telah dihapus!');
        } catch (\Throwable $th) {
            return redirect()->route('admin.mahasiswa')->with('error', 'Gagal menghapus data mahasiswa');
        }
    }

    public function exportPdf()
    {
        $mahasiswa = Mahasiswa::get();
    
        $data = [
            'title' => 'Data Mahasiswa',
            'mahasiswa' => $mahasiswa,
        ]; 
        
        $pdf = Pdf::loadView('admin.mahasiswa.pdf', $data);
    
        return $pdf->stream('data_mahasiswa.pdf');
    }

    // EXCEL
    public function exportExcel(){
        return Excel::download(new MahasiswaExport, 'Data_Mahasiswa.xlsx');
    }

    public function importExcel(Request $request){
        $request->validate([
            'file_excel' => 'required',
        ]);

        Excel::import(new MahasiswaImport, $request->file('file_excel'));

        return back()->with('success', 'Data mahasiswa telah berhasil diimpor');
    }
}
