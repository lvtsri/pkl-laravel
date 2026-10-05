<?php

namespace App\Exports;

use App\Models\DetailKelasMakul;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetailKelasExport implements FromCollection, WithHeadings
{
    protected $kode_kelas;

    public function __construct($kode_kelas)
    {
        $this->kode_kelas = $kode_kelas;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {
        $detail_kelas = DetailKelasMakul::with(['mahasiswa'])->where('kode_kelas', $this->kode_kelas)->get();

        $no = 1;
        return $detail_kelas->map(function ($item) use (&$no) {
            return [
                'no'   => $no++,
                'nim'  => $item->nim,
                'nama' => $item->mahasiswa->nama ?? '-',
            ];
        });
    }
    
    public function headings(): array
    {
        return ["No", "NIM", "Nama Mahasiswa"];
    }
}
