<?php

namespace App\Imports;

use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Override;

class JurusanImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek_jurusan = Jurusan::where('kode_jurusan', $row['kode_jurusan'])->exists();

        if ($cek_jurusan) {
            return null;
        }

        return new Jurusan([
            'kode_jurusan' => $row['kode_jurusan'],
            'nama_jurusan' => $row['nama_jurusan'],
        ]);
    }

    #[Override]
    public function rules(): array
    {
        return [
            'kode_jurusan' => 'required',
            'nama_jurusan' => 'required',
        ];
    }
}
