<?php

namespace App\Exports;

use App\Models\Claim;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClaimsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    public function query()
    {
        return Claim::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date',
            'Client Name',
            'Policy #',
            'Claim #',
            'Insurance Provider',
            'LOA Amount',
            'Deductibles',
            'Total Amount',
            'Admin Status',
            'Super Admin Status',
            'Created At',
        ];
    }

    public function map($claim): array
    {
        return [
            $claim->id,
            $claim->date_of_claim?->format('Y-m-d'),
            $claim->policy?->client_name ?? 'N/A',
            $claim->policy_number,
            $claim->claim_number,
            $claim->insuranceProvider->name ?? 'N/A',
            $claim->loa_amount ?? 0,
            $claim->deductible_participation ?? 0,
            $claim->total_amount ?? 0,
            $claim->admin_status,
            $claim->superadmin_status ?? 'Not Set',
            $claim->created_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,      // ID
            'B' => 12,     // Date
            'C' => 30,     // Client Name (increased width)
            'D' => 12,     // Policy #
            'E' => 12,     // Claim #
            'F' => 25,     // Insurance Provider
            'G' => 15,     // LOA Amount
            'H' => 15,     // Deductibles
            'I' => 15,     // Total Amount
            'J' => 15,     // Admin Status
            'K' => 18,     // Super Admin Status
            'L' => 18,     // Created At
        ];
    }
}
