<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $mahasiswa = Mahasiswa::select("nim", "nama", "kontak", "email", "kelamin")->get();
        $no = 1;

        return $mahasiswa->map(function ($item) use (&$no){
            return [
                'no' => $no++,
                'nim' => $item->nim,
                'nama' => $item->nama,
                'kontak' => $item->kontak,
                'email' => $item->email,
                'kelamin' => $item->kelamin == 'P' ? 'Perempuan' : 'Laki-laki',
            ];
        });
    }

    public function headings(): array{
        return ["No", "NIM", "Nama", "Kontak", "Email", "Jenis Kelamin"];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
                1 => ['font' => ['bold' => true],
            ],
        ];
    }
}
