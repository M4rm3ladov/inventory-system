<?php

namespace App\Exports;

use App\Models\Branch;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BranchesExport implements FromQuery, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    use Exportable;
    protected $searchQuery;

    public function __construct($searchQuery)
    {
        $this->searchQuery = $searchQuery;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1  => [
                'font' => ['bold' => true],
            ],

            'D' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],

            'B' => [
                'alignment' => ['wrapText' => true],
            ]
        ];
    }

    public function map($branch): array
    {
        return [
            $branch->name,
            $branch->address,
            $branch->email,
            $branch->phone
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Address',
            'Email',
            'Phone'
        ];
    }

    public function query()
    {
        return Branch::query()
            ->where('name', 'like', '%' . $this->searchQuery . '%')
            ->orWhere('address', 'like', '%' . $this->searchQuery . '%')
            ->orWhere('email', 'like', '%' . $this->searchQuery . '%')
            ->orWhere('phone', 'like', '%' . $this->searchQuery . '%');
    }
}
