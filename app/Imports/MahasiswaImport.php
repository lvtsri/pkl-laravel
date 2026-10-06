<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Hash;

class MahasiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek_mhs = Mahasiswa::where('nim', $row['nim'])->exists();
        
        if ($cek_mhs) {
            return null;
        }

        return new Mahasiswa([
            'nim' => $row['nim'],
            'nama' => $row['nama'],
            'kontak' => $row['kontak'],
            'email' => $row['email'],
            'kelamin' => $row['kelamin'],
        ]);
    }

    public function rules(): array{
        return [
            'nim' => 'required',
            'nama' => 'required',
            'kontak' => 'required',
            'email' => 'required',
            'kelamin' => 'required',
        ];
    }
}
