<?php

namespace App\Exports;

use App\Models\Jadwalkuliah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class JadwalKuliahExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    private $index = 0;

    public function collection()
    {
        // Ambil semua jadwal beserta relasi mataKuliah & ruang
        return Jadwalkuliah::with('mataKuliah', 'ruang')->get();
    }

    public function headings(): array
    {
        return [
            ['JADWAL KULIAH SEMESTER'], // Row 1
            ['Semester: ' . Jadwalkuliah::query()->value('semester')], // Row 2 dinamis
            ['INSTITUT TEKNOLOGI DAN SAINS MANDALA'], // Row 3
            [], // Row 4 (kosong)
            [   // Row 5 (header tabel)
                'No',
                'Mata Kuliah',
                'Dosen',
                'Program Studi',
                'Semester',
                'Group',
                'Hari',
                'Jam',
                'Ruangan',
            ]
        ];
    }

    public function map($row): array
    {
        return [
            ++$this->index,
            $row->mataKuliah->nama_mata_kuliah,
            $row->mataKuliah->dosen,
            $row->mataKuliah->program_studi,
            $row->semester,
            $row->group,
            $row->hari,
            $row->jam_mulai . ' - ' . $row->jam_selesai,
            $row->ruang->nama_ruang,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Ukuran kertas F4 (Folio)
                $event->sheet->getPageSetup()
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);

                // Merge judul dan institusi
                $event->sheet->mergeCells('A1:I1'); // judul
                $event->sheet->mergeCells('A2:I2'); // semester
                $event->sheet->mergeCells('A3:I3'); // institusi

                // Style judul
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => 'center']
                ]);
                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center']
                ]);
                $event->sheet->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center']
                ]);

                // Style header tabel
                $event->sheet->getStyle('A5:I5')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ]
                    ]
                ]);

                // Auto size kolom
                foreach (range('A', 'I') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Tanda tangan Warek 1
                $lastRow = $event->sheet->getHighestRow() + 3;
                $event->sheet->setCellValue("F{$lastRow}", "Jember, " . date('d F Y'));
                $event->sheet->setCellValue("F".($lastRow+1), "Wakil Rektor I");
                $event->sheet->setCellValue("F".($lastRow+5), "________________________");

                $event->sheet->getStyle("F{$lastRow}:I".($lastRow+5))->applyFromArray([
                    'alignment' => ['horizontal' => 'center'],
                    'font'      => ['bold' => true]
                ]);
            }
        ];
    }
}