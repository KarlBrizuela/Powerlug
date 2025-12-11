<?php

namespace App\Exports;

use App\Models\InsuranceProvider;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InsuranceProvidersExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return InsuranceProvider::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Provider Name',
            'Contact Person',
            'Email',
            'Phone',
            'Address',
            'Created At',
        ];
    }

    public function map($provider): array
    {
        return [
            $provider->id,
            $provider->name,
            $provider->contact_person,
            $provider->email,
            $provider->phone,
            $provider->address,
            $provider->created_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
