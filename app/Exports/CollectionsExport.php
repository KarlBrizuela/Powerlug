<?php

namespace App\Exports;

use App\Models\Collection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CollectionsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return Collection::with('client');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Collection Number',
            'Client Name',
            'Invoice Number',
            'Policy Number',
            'Claim Number',
            'Collection Amount (₱)',
            'LOA Amount (₱)',
            'Payment Method',
            'Collection Status',
            'Billing Status',
            'Collection Date',
            'Bank Name',
            'LOA Reference',
            'Created At',
            'Updated At',
        ];
    }

    public function map($collection): array
    {
        return [
            $collection->id,
            $collection->collection_number,
            $collection->client ? $collection->client->firstName . ' ' . $collection->client->lastName : '',
            $collection->invoice_number,
            $collection->policy_number,
            $collection->claim_number,
            $collection->collection_amount,
            $collection->loa_amount,
            $collection->payment_method,
            $collection->collection_status,
            $collection->billing_status,
            $collection->collection_date,
            $collection->bank_name,
            $collection->loa,
            $collection->created_at,
            $collection->updated_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']],
            ],
        ];
    }
}
