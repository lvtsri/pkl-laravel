<?php

namespace App\Exports\Jurusan;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Override;

class JurusanTemplateExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */    public function sheets(): array
    {
        return [
            0 => new SheetKosongExport(),
            1 => new SheetPanduanExport(),
        ];
    }
}
