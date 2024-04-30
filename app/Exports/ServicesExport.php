<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ServicesExport implements FromQuery, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    use Exportable;
    protected $searchQuery;
    protected $sortBy = 'created_at';
    protected $sortDirection = 'DESC';
    protected $category = -1;

    protected $priceAFrom = '';
    protected $priceATo = '';
    protected $priceBFrom = '';
    protected $priceBTo = '';

    public function __construct(
        $searchQuery,
        $sortBy,
        $sortDirection,
        $category,
        $priceAFrom,
        $priceATo,
        $priceBFrom,
        $priceBTo
    ) {
        $this->searchQuery = $searchQuery;
        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;
        $this->category = $category;
        $this->priceAFrom = $priceAFrom;
        $this->priceATo = $priceATo;
        $this->priceBFrom = $priceBFrom;
        $this->priceBTo = $priceBTo;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1  => [
                'font' => ['bold' => true],
            ],

            'A' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],

            'D' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],

            'E' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],
        ];
    }

    public function map($service): array
    {
        return [
            $service->code,
            $service->serviceName,
            $service->categoryName,
            $service->price_A,
            $service->price_B,
        ];
    }

    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Category',
            'Price A',
            'Price B'
        ];
    }

    public function query()
    {
        $services = Service::search($this->searchQuery)
            ->select('services.name AS serviceName', 'services.*', 'service_categories.name AS categoryName')
            ->join('service_categories', 'services.service_category_id', '=', 'service_categories.id')
            ->when($this->category != -1, function ($query) {
                $query->where('service_category_id', $this->category);
            })
            ->when($this->priceAFrom && $this->priceATo != '', function ($query) {
                $query->whereBetween('price_A', [$this->priceAFrom, $this->priceATo]);
            })
            ->when($this->priceBFrom && $this->priceBTo != '', function ($query) {
                $query->whereBetween('price_B', [$this->priceBFrom, $this->priceBTo]);
            });

        // order by for category relationship
        if ($this->sortBy == 'category') {
            $services = $services->orderBy('categoryName', $this->sortDirection);
        } else {
            $services = $services->orderBy($this->sortBy, $this->sortDirection);
        }
        return $services;
    }
}
