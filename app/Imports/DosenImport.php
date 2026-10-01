<?php

namespace App\Imports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Hash;

class DosenImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Dosen([
            'nik' => $row['nik'],
            'nama' => $row['nama'],
            'kontak' => $row['kontak'],
            'email' => $row['email'],
            'kelamin' => $row['kelamin'],
        ]);
    }

    public function rules(): array{
        return [
            'nik' => 'required',
            'nama' => 'required',
            'kontak' => 'required',
            'email' => 'required',
            'kelamin' => 'required',
        ];
    }
}
