<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoriesExport implements  FromQuery, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    use Exportable;

    public $searchQuery = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'DESC';
    public $branch = -1;
    public $category = -1;
    public $brand = -1;
    public $unit = -1;

    public function __construct(
        $searchQuery,
        $sortBy,
        $sortDirection,
        $branch,
        $category,
        $brand,
        $unit,
    ) {
        $this->searchQuery = $searchQuery;
        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;
        $this->branch = $branch;
        $this->category = $category;
        $this->brand = $brand;
        $this->unit = $unit;
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

    public function map($inventory): array
    {
        return [
            $inventory->branchName,
            $inventory->quantity,
            $inventory->code,
            $inventory->itemName,
            $inventory->description,
            $inventory->categoryName,
            $inventory->brandName,
            $inventory->unitName,
            $inventory->createdAt,
            $inventory->updatedAt,
        ];
    }

    public function headings(): array
    {
        return [
            'Branch',
            'Quantity',
            'Code',
            'Name',
            'Description',
            'Category',
            'Brand',
            'Unit',
            'Created At',
            'Updated At',
        ];
    }

    public function query()
    {
        $inventories = Inventory::search($this->searchQuery)
            ->select(
                'branches.name AS branchName',
                'items.name AS itemName',
                'item_categories.name AS categoryName',
                'brands.name AS brandName',
                'units.name AS unitName',
                'items.*',
                'inventories.created_at AS createdAt',
                'inventories.updated_at AS updatedAt',
                'inventories.*'
            )
            ->join('items', 'inventories.item_id', '=', 'items.id')
            ->join('branches', 'inventories.branch_id', '=', 'branches.id')
            ->join('item_categories', 'items.item_category_id', '=', 'item_categories.id')
            ->join('brands', 'items.brand_id', '=', 'brands.id')
            ->join('units', 'items.unit_id', '=', 'units.id')
            ->when($this->branch != 'All', function ($query) {
                $query->where('branches.name', $this->branch);
            })
            ->when($this->category != 'All', function ($query) {
                $query->where('item_categories.name', $this->category);
            })
            ->when($this->brand != 'All', function ($query) {
                $query->where('brands.name', $this->brand);
            })
            ->when($this->unit != 'All', function ($query) {
                $query->where('units.name', $this->unit);
            });

        // order by for category relationship
        if ($this->sortBy == 'branch') {
            $inventories = $inventories->orderBy('branches.name', $this->sortDirection);
        } else if ($this->sortBy == 'category') {
            $inventories = $inventories->orderBy('item_categories.name', $this->sortDirection);
        } elseif ($this->sortBy == 'brand') {
            $inventories = $inventories->orderBy('brands.name', $this->sortDirection);
        } elseif ($this->sortBy == 'unit') {
            $inventories = $inventories->orderBy('units.name', $this->sortDirection);
        } elseif ($this->sortBy == 'created_at') {
            $inventories = $inventories->orderBy('inventories.created_at', $this->sortDirection);
        } elseif ($this->sortBy == 'updated_at') {
            $inventories = $inventories->orderBy('inventories.updated_at', $this->sortDirection);
        } else {
            $inventories = $inventories->orderBy($this->sortBy, $this->sortDirection);
        }

        return $inventories;
    }
}