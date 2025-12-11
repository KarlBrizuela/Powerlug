<?php

namespace App\Exports;

use App\Models\Freebie;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FreebiesExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return Freebie::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Freebie Name',
            'Description',
            'Created At',
        ];
    }

    public function map($freebie): array
    {
        return [
            $freebie->id,
            $freebie->name,
            $freebie->description,
            $freebie->created_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
