<?php

namespace App\Exports;

use App\Models\Akademik;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Override;

class AkademikExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $akademik = Akademik::all();
        $no = 1;

        return $akademik->map(function ($item) use (&$no){
            return [
                'no' => $no++,
                'kode_akd' => $item->kode_akd,
                'semester' => $item->semester == 'GL' ? 'Ganjil' : 'Genap',
                'tahun' => $item->tahun,
                'is_active' => $item->is_active == '1' ? 'Aktif' : 'Tidak aktif',
            ];
        });
    }

    public function headings(): array
    {
        return ["No", "Kode Akademik", "Semester", "Tahun", "Status"];
    }
}
