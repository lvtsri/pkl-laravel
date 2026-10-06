<?php

namespace App\Exports;

use App\Models\Pertemuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PertemuanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
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
        $pertemuan = Pertemuan::where('kode_kelas', $this->kode_kelas)->get();

        return $pertemuan->map(function($item) use (&$no){
            return [
                'pertemuan_ke' => $item->pertemuan_ke,
                'judul_pertemuan' => $item->judul_pertemuan,
                'tanggal' => $item->tanggal,
            ];
        });
    }

    public function headings(): array
    {
        return ["Pertemuan ke", "Judul Pertemuan", "Tanggal"];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
                1 => ['font' => ['bold' => true],
            ],
        ];
    }
}
