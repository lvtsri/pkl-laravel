<?php

namespace App\Exports;

use App\Models\Makul;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Override;

class MakulExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $makul = Makul::all();
        $no = 1;

        return $makul->map(function ($item) use (&$no){
            return [
                'no' => $no++,
                'kode_makul' => $item->kode_makul,
                'nama_makul' => $item->nama_makul,
                'jml_sks' => $item->jml_sks,
                'jml_cpmk' => $item->jml_cpmk,
            ];
        });
    }

    public function headings(): array
    {
        return ["No", "Kode", "Nama Mata Kuliah", "Jumlah SKS", "Jumlah CPMK"];
    }
}
