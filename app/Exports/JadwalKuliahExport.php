<?php

namespace App\Exports;

use App\Models\Jadwalkuliah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Border;

class JadwalKuliahExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    private int $index = 0;
    private string $semester;

    public function __construct()
    {
        $this->semester = Jadwalkuliah::distinct()
            ->orderBy('semester')
            ->pluck('semester')
            ->implode(', ');
    }

    public function collection()
    {
        return Jadwalkuliah::with(['mata_kuliah', 'ruang'])
            ->orderBy('semester')
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();
    }

    public function headings(): array
    {
        return [
            ['JADWAL KULIAH'],
            ['Semester: ' . $this->semester],
            ['INSTITUT TEKNOLOGI DAN SAINS MANDALA'],
            [],
            [
                'No',
                'Hari',
                'Jam',
                'Mata Kuliah',
                'Dosen',
                'Program Studi',
                'Semester',
                'Group',
                'Ruangan',
            ]
        ];
    }

    public function map($row): array
    {
        return [
            ++$this->index,
            $row->hari,
            $row->jam_mulai . ' - ' . $row->jam_selesai,
            $row->mata_kuliah->nama_mata_kuliah ?? '-',
            $row->mata_kuliah->dosen->nama ?? '-',
            $row->mata_kuliah->program_studi->nama ?? '-',
            $row->semester,
            $row->mata_kuliah->group ?? '-',
            $row->ruang->nama_ruang ?? '-',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // KERTAS F4
                $event->sheet->getPageSetup()
                    ->setPaperSize(PageSetup::PAPERSIZE_FOLIO);

                // MERGE JUDUL
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->mergeCells('A2:I2');
                $event->sheet->mergeCells('A3:I3');

                // STYLE JUDUL
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                $event->sheet->getStyle('A2:A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // HEADER TABEL
                $event->sheet->getStyle('A5:I5')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // AUTO SIZE
                foreach (range('A', 'I') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // TTD WAREK I
                $lastRow = $event->sheet->getHighestRow() + 3;
                $event->sheet->setCellValue("F{$lastRow}", 'Jember, ' . date('d F Y'));
                $event->sheet->setCellValue("F" . ($lastRow + 1), 'Wakil Rektor I');
                $event->sheet->setCellValue("F" . ($lastRow + 5), '________________________');

                $event->sheet->getStyle("F{$lastRow}:I" . ($lastRow + 5))->applyFromArray([
                    'alignment' => ['horizontal' => 'center'],
                    'font' => ['bold' => true],
                ]);
            }
        ];
    }
}