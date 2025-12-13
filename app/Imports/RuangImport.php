<?php

namespace App\Imports;

use App\Models\Ruang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RuangImport implements ToModel, WithHeadingRow
{
public function model(array $row)
{
    return new Ruang([
        'nama_ruang'  => $row['nama_ruang'],
        'kapasitas'   => $row['kapasitas'],
        'jam_mulai'   => $this->excelTimeToString($row['jam_mulai']),
        'jam_selesai' => $this->excelTimeToString($row['jam_selesai']),
    ]);
}

private function excelTimeToString($value)
{
    if (is_numeric($value)) {
        return gmdate('H:i', ($value * 86400));
    }
    return $value;
}

}
