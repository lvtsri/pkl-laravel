<?php

namespace App\Imports;

use App\Models\Akademik;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Override;

class AkademikImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek_akademik = Akademik::where('kode_akd', $row['kode_akd'])->exists();

        if ($cek_akademik) {
            return null;
        }

        $input_sem = strtoupper(trim($row['semester']));    //ubah inputan jadi kapital

        if ($input_sem === 'GANJIL' || $input_sem === 'GL') {
            $semester = 'GL';
        } else {
            $semester = 'GN';
        }
        
        $input_active = strtoupper(trim($row['is_active']));
        if ($input_active === 'AKTIF' || $input_active === '1') {
            $is_active = '1';
        } else {
            $is_active = '0';
        }

        return new Akademik([
            'kode_akd' => $row['kode_akd'],
            'semester' => $semester,
            'tahun' => $row['tahun'],
            'is_active' => $is_active,
        ]);
    }

    #[Override]
    public function rules(): array
    {
        return [
            'kode_akd' => 'required',
            'semester' => 'required',
            'tahun' => 'required',
            'is_active' => 'required',
        ];
    }
}
