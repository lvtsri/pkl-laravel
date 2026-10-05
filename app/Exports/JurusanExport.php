<?php

namespace App\Exports;

use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JurusanExport implements FromCollection, WithHeadings
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
}
