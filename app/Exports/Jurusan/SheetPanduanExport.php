<?php

namespace App\Exports\Jurusan;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
// use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Str;
use App\Models\Jurusan;
use Override;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SheetPanduanExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles, WithTitle, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    #[Override]
    public function title(): string
    {
        return 'Panduan & Contoh';
    }

    #[Override]
    public function headings(): array
    {
        return ['No', 'Kode Jurusan', 'Nama Jurusan'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
                1 => ['font' => ['bold' => true],
            ],
        ];
    }

    #[Override]
    public function collection()
    {
        $jurusan = Jurusan::take(5)->get();

        $no = 1;
        return $jurusan->map(function ($item) use (&$no) {
            return [
                'no' => $no++,
                'kode_jurusan' => $item->kode_jurusan,
                'nama_jurusan' => $item->nama_jurusan,
            ];
        });
    }

    #[Override]
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:C10';
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,   // Garis tipis
                            'color' => ['argb' => '000000'],        // Warna hitam
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $event->sheet->setCellValue('E1', 'Aturan Pengisian:');
                $event->sheet->setCellValue('E2', '1. Masukkan data pada sheet Format Impor Data');
                $event->sheet->setCellValue('E3', '2. Contoh pengisian data dapat dilihat pada tabel di samping');

                $event->sheet->getColumnDimension('B')->setVisible(false);
            },
        ];
    }
}
