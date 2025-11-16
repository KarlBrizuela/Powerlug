<?php

namespace App\Exports;

use App\Models\Commission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CommissionsExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles
{
    protected $commissions;

    public function __construct($commissions)
    {
        $this->commissions = $commissions;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->commissions;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Insurance Provider',
            'Policy Number',
            'Insured',
            'Gross Premium',
            'Net Premium',
            'LOA',
            'Commission',
            'Payment Status',
            'Created Date'
        ];
    }

    /**
     * @param mixed $commission
     * @return array
     */
    public function map($commission): array
    {
        return [
            $commission->insuranceProvider ? $commission->insuranceProvider->name : '',
            $commission->policy_number,
            $commission->insured,
            number_format($commission->gross_premium, 2),
            number_format($commission->net_premium, 2),
            $commission->loa,
            number_format($commission->commission_amount, 2),
            ucfirst($commission->payment_status),
            $commission->created_at->format('Y-m-d')
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 25,  // Insurance Provider
            'B' => 20,  // Policy Number
            'C' => 30,  // Insured
            'D' => 15,  // Gross Premium
            'E' => 15,  // Net Premium
            'F' => 15,  // LOA
            'G' => 15,  // Commission
            'H' => 18,  // Payment Status
            'I' => 15,  // Created Date
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12,
                ],
            ],
        ];
    }
}
