<?php

namespace App\Exports;

use App\Models\Claim;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClaimsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return Claim::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Policy #',
            'Client Name',
            'Plate Number',
            'Date of Incident',
            'Claim Amount',
            'Status',
            'Description',
            'Created At',
        ];
    }

    public function map($claim): array
    {
        return [
            $claim->id,
            $claim->policy_id ?? '',
            $claim->client_name,
            $claim->plate_number,
            $claim->date_of_incident,
            $claim->claim_amount,
            $claim->status,
            $claim->description,
            $claim->created_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
