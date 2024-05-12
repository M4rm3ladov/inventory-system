<?php

namespace App\Exports;

use App\Models\StockTransfer;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockTransfersExport implements FromQuery, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    use Exportable;

    public $searchQuery = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'DESC';
    public $branchTo = -1;
    public $category = -1;
    public $brand = -1;
    public $unit = -1;

    public $dateFrom = '';
    public $dateTo = '';

    public function __construct(
        $searchQuery,
        $sortBy,
        $sortDirection,
        $branchTo,
        $category,
        $brand,
        $unit,
        $dateFrom,
        $dateTo
    ) {
        $this->searchQuery = $searchQuery;
        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;
        $this->branchTo = $branchTo;
        $this->category = $category;
        $this->brand = $brand;
        $this->unit = $unit;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1  => [
                'font' => ['bold' => true],
            ],

            'B' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function map($stockIn): array
    {
        return [
            $stockIn->branchTo,
            $stockIn->quantity,
            $stockIn->code,
            $stockIn->itemName,
            $stockIn->description,
            $stockIn->categoryName,
            $stockIn->brandName,
            $stockIn->unitName,
            $stockIn->transact_date,
            $stockIn->createdAt,
            $stockIn->updatedAt,
        ];
    }

    public function headings(): array
    {
        return [
            'Branch Transferred',
            'Quantity',
            'Code',
            'Name',
            'Description',
            'Category',
            'Brand',
            'Unit',
            'Transaction Date',
            'Created At',
            'Updated At',
        ];
    }

    public function query()
    {
        $stockTransfers = StockTransfer::search($this->searchQuery)
            ->select(
                'branches.name AS branchTo',
                'items.name AS itemName',
                'inventories.item_id',
                'item_categories.name AS categoryName',
                'brands.name AS brandName',
                'units.name AS unitName',
                'items.*',
                'stock_transfers.created_at AS createdAt',
                'stock_transfers.updated_at AS updatedAt',
                'stock_transfers.*'
            )
            ->join('branches', 'stock_transfers.branch_id_to', '=', 'branches.id')
            ->join('inventories', 'stock_transfers.inventory_id', '=', 'inventories.id')
            ->join('items', 'inventories.item_id', '=', 'items.id')
            ->join('item_categories', 'items.item_category_id', '=', 'item_categories.id')
            ->join('brands', 'items.brand_id', '=', 'brands.id')
            ->join('units', 'items.unit_id', '=', 'units.id')
            ->when($this->branchTo != 'All', function ($query) {
                $query->where('branches.name', $this->branchTo);
            })
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
            ->where('inventories.branch_id', '=', Auth::user()->branch_id);

        // order by for category relationship
        if ($this->sortBy == 'category') {
            $stockTransfers = $stockTransfers->orderBy('item_categories.name', $this->sortDirection);
        } elseif ($this->sortBy == 'brand') {
            $stockTransfers = $stockTransfers->orderBy('brands.name', $this->sortDirection);
        } elseif ($this->sortBy == 'unit') {
            $stockTransfers = $stockTransfers->orderBy('units.name', $this->sortDirection);
        } elseif ($this->sortBy == 'branchTo') {
            $stockTransfers = $stockTransfers->orderBy('branches.name', $this->sortDirection);
        } else if ($this->sortBy == 'transaction_date') {
            $stockTransfers = $stockTransfers->orderBy('transact_date', $this->sortDirection);
        } else if ($this->sortBy == 'created_at') {
            $stockTransfers = $stockTransfers->orderBy('stock_transfers.created_at', $this->sortDirection);
        } else if ($this->sortBy == 'updated_at') {
            $stockTransfers = $stockTransfers->orderBy('stock_transfers.updated_at', $this->sortDirection);
        } else {
            $stockTransfers = $stockTransfers->orderBy($this->sortBy, $this->sortDirection);
        }

        return $stockTransfers;
    }
}

