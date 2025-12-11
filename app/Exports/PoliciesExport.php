<?php

namespace App\Exports;

use App\Models\Policy;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PoliciesExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return Policy::with('client', 'insuranceProvider');
    }

    public function headings(): array
    {
        return [
            'Policy #',
            'Client Name',
            'Provider',
            'Premium',
            'VAT',
            'Documentary Stamp Tax',
            'Local Gov Tax',
            'Amount Due',
            'Paid Amount',
            'Balance',
            'Payment Terms',
            'Status',
            'Coverage From',
            'Coverage To',
            'Created At',
        ];
    }

    public function map($policy): array
    {
        return [
            $policy->policy_number,
            $policy->client_name ?? ($policy->client ? $policy->client->firstName . ' ' . $policy->client->lastName : ''),
            $policy->insuranceProvider ? $policy->insuranceProvider->name : '',
            $policy->premium,
            $policy->vat,
            $policy->documentary_stamp_tax,
            $policy->local_gov_tax,
            $policy->amount_due,
            $policy->paid_amount,
            ($policy->amount_due - $policy->paid_amount),
            $policy->payment_terms,
            $policy->status,
            $policy->coverage_from,
            $policy->coverage_to,
            $policy->created_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
