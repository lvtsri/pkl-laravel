<?php

namespace App\Exports;

use App\Models\KelasMakul;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KelasMakulExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $kelas_makul = KelasMakul::with(['akademik', 'makul', 'jurusan', 'dosen'])->get();
        $no = 1;

        return $kelas_makul->map(function ($item) use (&$no){
            return [
                'no' => $no++,
                'nama_kelas' => $item->nama_kelas,
                'kode_akd' => $item->kode_akd,
                'nama_makul' => $item->makul->nama_makul,
                'nama_jurusan' => $item->jurusan->nama_jurusan,
                'dosen' => $item->dosen->nama,
            ];
        });
    }

    public function headings(): array
    {
        return ["No", "Kelas", "Periode Akademik", "Mata Kuliah", "Jurusan", "Dosen"];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
                1 => ['font' => ['bold' => true],
            ],
        ];
    }
}
