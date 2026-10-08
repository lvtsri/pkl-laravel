<?php

namespace App\Imports;

use App\Models\Makul;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Override;

class MakulImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek_makul = Makul::where('kode_makul', $row['kode_makul'])->exists();

        if ($cek_makul) {
            return null;
        }

        return new Makul([
            'kode_makul' => $row['kode_makul'],
            'nama_makul' => $row['nama_makul'],
            'jml_sks' => $row['jml_sks'],
            'jml_cpmk' => $row['jml_cpmk'],
        ]);
    }

    #[Override]
    public function rules(): array
    {
        return [
            'kode_makul' => 'required',
            'nama_makul' => 'required',
            'jml_sks' => 'required',
            'jml_cpmk' => 'required',
        ];
    }
}
