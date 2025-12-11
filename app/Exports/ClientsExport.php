<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return Client::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Middle Name',
            'Last Name',
            'Email',
            'Phone',
            'Address',
            'City',
            'Province',
            'Postal Code',
            'TIN',
            'Make Model',
            'Plate No',
            'Model Year',
            'Color',
            'Created At',
            'Updated At',
        ];
    }

    public function map($client): array
    {
        return [
            $client->id,
            $client->firstName,
            $client->middleName,
            $client->lastName,
            $client->email,
            $client->phone,
            $client->address,
            $client->city,
            $client->province,
            $client->postalCode,
            $client->tin,
            $client->make_model,
            $client->plate_no,
            $client->model_year,
            $client->color,
            $client->created_at,
            $client->updated_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
