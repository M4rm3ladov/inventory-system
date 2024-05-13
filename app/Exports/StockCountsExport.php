<?php

namespace App\Exports;

use App\Models\StockCount;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockCountsExport implements FromQuery, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    use Exportable;

    public $searchQuery = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'DESC';
    public $category = -1;
    public $brand = -1;
    public $unit = -1;

    public $dateFrom = '';
    public $dateTo = '';
    public $periodFrom = '';
    public $periodTo = '';

    public function __construct(
        $searchQuery,
        $sortBy,
        $sortDirection,
        $category,
        $brand,
        $unit,
        $dateFrom,
        $dateTo,
        $periodFrom,
        $periodTo,
    ) {
        $this->searchQuery = $searchQuery;
        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;
        $this->category = $category;
        $this->brand = $brand;
        $this->unit = $unit;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->periodFrom = $periodFrom;
        $this->periodTo = $periodTo;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1  => [
                'font' => ['bold' => true],
            ],

            'A' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function map($stockIn): array
    {
        return [
            $stockIn->quantity,
            $stockIn->code,
            $stockIn->itemName,
            $stockIn->description,
            $stockIn->categoryName,
            $stockIn->brandName,
            $stockIn->unitName,
            $stockIn->transact_date,
            $stockIn->period_from,
            $stockIn->period_to,
            $stockIn->createdAt,
            $stockIn->updatedAt,
        ];
    }

    public function headings(): array
    {
        return [
            'Quantity',
            'Code',
            'Name',
            'Description',
            'Category',
            'Brand',
            'Unit',
            'Transaction Date',
            'Period From',
            'Period To',
            'Created At',
            'Updated At',
        ];
    }

    public function query()
    {
        $stockCounts = StockCount::search($this->searchQuery)
            ->select(
                'items.name AS itemName',
                'item_categories.name AS categoryName',
                'brands.name AS brandName',
                'units.name AS unitName',
                'items.*',
                'stock_counts.created_at AS createdAt',
                'stock_counts.updated_at AS updatedAt',
                'stock_counts.*'
            )
            ->join('inventories', 'stock_counts.inventory_id', '=', 'inventories.id')
            ->join('items', 'inventories.item_id', '=', 'items.id')
            ->join('item_categories', 'items.item_category_id', '=', 'item_categories.id')
            ->join('brands', 'items.brand_id', '=', 'brands.id')
            ->join('units', 'items.unit_id', '=', 'units.id')
            ->when($this->category != 'All', function ($query) {
                $query->where('item_categories.name', $this->category);
            })
            ->when($this->brand != 'All', function ($query) {
                $query->where('brands.name', $this->brand);
            })
            ->when($this->unit != 'All', function ($query) {
                $query->where('units.name', $this->unit);
            })
            ->when($this->dateFrom && $this->dateTo != '', function ($query) {
                $query->whereBetween('transact_date', [$this->dateFrom, $this->dateTo]);
            })
            ->when($this->periodFrom && $this->periodTo != '', function ($query) {
                $query->whereDate('period_from', '>=',  $this->periodFrom)
                    ->whereDate('period_to', '<=', $this->periodTo);
            })
            ->where('inventories.branch_id', '=', Auth::user()->branch_id);

        // order by for category relationship
        if ($this->sortBy == 'category') {
            $stockCounts = $stockCounts->orderBy('item_categories.name', $this->sortDirection);
        } elseif ($this->sortBy == 'brand') {
            $stockCounts = $stockCounts->orderBy('brands.name', $this->sortDirection);
        } elseif ($this->sortBy == 'unit') {
            $stockCounts = $stockCounts->orderBy('units.name', $this->sortDirection);
        } else if ($this->sortBy == 'transaction_date') {
            $stockCounts = $stockCounts->orderBy('transact_date', $this->sortDirection);
        } else if ($this->sortBy == 'period_from') {
            $stockCounts = $stockCounts->orderBy('period_from', $this->sortDirection);
        } else if ($this->sortBy == 'period_to') {
            $stockCounts = $stockCounts->orderBy('period_to', $this->sortDirection);
        } else if ($this->sortBy == 'created_at') {
            $stockCounts = $stockCounts->orderBy('stock_counts.created_at', $this->sortDirection);
        } else if ($this->sortBy == 'updated_at') {
            $stockCounts = $stockCounts->orderBy('stock_counts.updated_at', $this->sortDirection);
        } else {
            $stockCounts = $stockCounts->orderBy($this->sortBy, $this->sortDirection);
        }

        return $stockCounts;
    }
}
