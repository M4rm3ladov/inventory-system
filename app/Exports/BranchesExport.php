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
    protected $sortBy;
    protected $sortDirection;

    public function __construct($searchQuery, $sortBy, $sortDirection)
    {
        $this->searchQuery = $searchQuery;
        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;
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
        return Branch::search($this->searchQuery)
            ->orderBy($this->sortBy, $this->sortDirection);
    }
}
