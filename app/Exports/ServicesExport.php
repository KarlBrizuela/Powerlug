<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ServicesExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return Service::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Service Name',
            'Price',
            'Description',
            'Created At',
        ];
    }

    public function map($service): array
    {
        return [
            $service->id,
            $service->service_name,
            $service->price,
            $service->description,
            $service->created_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
