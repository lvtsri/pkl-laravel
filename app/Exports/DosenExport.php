<?php

namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;  //lebar auto
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DosenExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $dosen = Dosen::select("nik", "nama", "kontak", "email", "kelamin")->get();
        $no = 1;

        return $dosen->map(function ($item) use (&$no){
            return [
                'no' => $no++,
                'nik' => $item->nik,
                'nama' => $item->nama,
                'kontak' => $item->kontak,
                'email' => $item->email,
                'kelamin' => $item->kelamin == 'P' ? 'Perempuan' : 'Laki-laki',
            ];
        });
    }

    public function headings(): array{
        return ["No", "NIK", "Nama", "Kontak", "Email", "Jenis Kelamin"];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
                1 => ['font' => ['bold' => true],
            ],
        ];
    }
}
