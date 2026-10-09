<?php

namespace App\Exports\Jurusan;

use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
// use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Str;
use Override;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SheetKosongExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles, WithTitle, WithEvents
{
    #[Override]
    public function title(): string
    {
        return 'Format Impor Data Jurusan';
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
        $rows = [];
        $kodeGenerate = [];
        
        for ($i=1; $i <=10; $i++) {
            do {
                $kode = 'J-' . Str::upper(Str::random(4));  //generate kode acak J-XXXX

                $existCode = Jurusan::where('kode_jurusan', $kode)->exists();
                $existsInCurrentBatch = in_array($kode, $kodeGenerate);     //in_array(apa_yang_dicari, di_dalam_wadah_mana) jadi memberi jawaban true/false apakah kode tsb sama dgn kode generate lainnya
            } while ($existCode || $existsInCurrentBatch);  //ulangin terus klo masih kembar

            $kodeGenerate[] = $kode;    //simpan hasil $kode ke wadah $kodeGenerate yang kosong tadi
            $rows[] = [$i, $kode, ''];  //Masukin no baris, kode unik, dan kolom kosong untuk diisi data nama jurusan oleh user
        }

        return collect($rows); //
    }

    #[Override]
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $cellRange = 'A1:C11';
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
                
                $event->sheet->setCellValue('E1', 'Note: Jangan ubah struktur kolom!');
                $event->sheet->setCellValue('E2', 'Coba xx');

                $event->sheet->getColumnDimension('B')->setVisible(false);
            },
        ];
    }
}
