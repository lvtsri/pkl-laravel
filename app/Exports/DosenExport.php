<?php

namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;

class DosenExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Dosen::select("nik", "nama", "kontak", "email", "kelamin")->get();
    }

    public function headings(): array{
        return ["NIK", "Nama", "Kontak", "Email", "Jenis Kelamin"];
    }
}
