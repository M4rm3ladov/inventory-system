<?php

namespace App\Exports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UnitsExport implements FromQuery, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
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
        ];
    }

    public function map($unit): array
    {
        return [
            $unit->name,
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
        ];
    }

    public function query()
    {
        return Unit::search($this->searchQuery);
    }
}
