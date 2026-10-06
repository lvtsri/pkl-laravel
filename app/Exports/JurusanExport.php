<?php

namespace App\Exports;

use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JurusanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $jurusan = Jurusan::all();

        $no = 1;
        return $jurusan->map(function ($item) use (&$no) {
            return [
                'no' => $no++,
                'kode_jurusan' => $item->kode_jurusan,
                'nama_jurusan' => $item->nama_jurusan,
            ];
        });
    }

    public function headings(): array {
        return ["No", "Kode Jurusan", "Nama Jurusan"];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
                1 => ['font' => ['bold' => true],
            ],
        ];
    }
}
