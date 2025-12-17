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
    private string $judulSemester = '';
    private string $judulProdi = '';
    private string $judulFakultas = '';

    public function __construct()
    {
        $first = Jadwalkuliah::with([
            'mata_kuliah.program_studi',
            'mata_kuliah.fakultas'
        ])->first();

        $this->judulSemester = $first->semester ?? '-';
        $this->judulProdi    = $first->mata_kuliah->program_studi->nama ?? 'SEMUA PROGRAM STUDI';
        $this->judulFakultas = $first->mata_kuliah->fakultas->nama ?? 'SEMUA FAKULTAS';
    }

    public function collection()
    {
        return Jadwalkuliah::with([
            'mata_kuliah.dosen',
            'mata_kuliah.program_studi',
            'mata_kuliah.fakultas',
            'ruang'
        ])
        ->orderBy('semester')
        ->orderBy('hari')
        ->orderBy('jam_mulai')
        ->get();
    }

    public function headings(): array
    {
        return [
            ['JADWAL KULIAH'],
            ['FAKULTAS ' . strtoupper($this->judulFakultas)],
            ['PROGRAM STUDI ' . strtoupper($this->judulProdi)],
            ['SEMESTER ' . $this->judulSemester],
            ['INSTITUT TEKNOLOGI DAN SAINS MANDALA'],
            [],
            [
                'No',
                'Hari',
                'Jam',
                'Mata Kuliah',
                'Dosen',
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
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->mergeCells('A2:G2');
                $event->sheet->mergeCells('A3:G3');
                $event->sheet->mergeCells('A4:G4');
                $event->sheet->mergeCells('A5:G5');

                // STYLE JUDUL
                $event->sheet->getStyle('A1:A5')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // HEADER TABEL
                $event->sheet->getStyle('A7:G7')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // AUTO WIDTH
                foreach (range('A', 'G') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // TTD
                $lastRow = $event->sheet->getHighestRow() + 3;
                $event->sheet->setCellValue("E{$lastRow}", 'Jember, ' . date('d F Y'));
                $event->sheet->setCellValue("E" . ($lastRow + 1), 'Bagian Akademik');
                $event->sheet->setCellValue("E" . ($lastRow + 5), '( ____________________ )');

                $event->sheet->getStyle("E{$lastRow}:G" . ($lastRow + 5))->applyFromArray([
                    'alignment' => ['horizontal' => 'center'],
                    'font' => ['bold' => true],
                ]);
            }
        ];
    }
}
