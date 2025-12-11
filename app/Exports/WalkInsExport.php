<?php

namespace App\Exports;

use App\Models\WalkIn;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WalkInsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return WalkIn::query();
    }

    public function headings(): array
    {
        return [
            'Walk-in #',
            'Insured Name',
            'Unit',
            'Plate Number',
            'Address',
            'Contact Number',
            'Email',
            'Premium',
            'VAT',
            'Documentary Stamp Tax',
            'Local Gov Tax',
            'Amount Due',
            'Paid Amount',
            'Payment Terms',
            'Payment Method',
            'Status',
            'Created At',
        ];
    }

    public function map($walkin): array
    {
        return [
            $walkin->walkin_number,
            $walkin->insured_name,
            $walkin->unit,
            $walkin->plate_number,
            $walkin->address,
            $walkin->contact_number,
            $walkin->email,
            $walkin->premium,
            $walkin->vat,
            $walkin->documentary_stamp_tax,
            $walkin->local_gov_tax,
            $walkin->amount_due,
            $walkin->paid_amount,
            $walkin->payment_terms,
            $walkin->payment_method,
            $walkin->status,
            $walkin->created_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
