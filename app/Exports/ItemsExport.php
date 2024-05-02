<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemsExport implements FromQuery, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    use Exportable;
    protected $searchQuery;
    protected $sortBy = 'created_at';
    protected $sortDirection = 'DESC';
    protected $category = -1;
    protected $brand = -1;
    protected $unit = -1;

    protected $unitPriceFrom = '';
    protected $unitPriceTo = '';
    protected $priceAFrom = '';
    protected $priceATo = '';
    protected $priceBFrom = '';
    protected $priceBTo = '';

    public function __construct(
        $searchQuery,
        $sortBy,
        $sortDirection,
        $category,
        $brand,
        $unit,
        $unitPriceFrom,
        $unitPriceTo,
        $priceAFrom,
        $priceATo,
        $priceBFrom,
        $priceBTo
    ) {
        $this->searchQuery = $searchQuery;
        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;
        $this->category = $category;
        $this->brand = $brand;
        $this->unit = $unit;
        $this->unitPriceFrom = $unitPriceFrom;
        $this->unitPriceTo = $unitPriceTo;
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

            'G' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],

            'H' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],
            'I' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],
        ];
    }

    public function map($item): array
    {
        return [
            $item->code,
            $item->itemName,
            $item->description,
            $item->categoryName,
            $item->brandName,
            $item->unitName,
            $item->unit_price,
            $item->price_A,
            $item->price_B,
        ];
    }

    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Description',
            'Category',
            'Brand',
            'Unit',
            'Supplier Price',
            'Price A',
            'Price B'
        ];
    }

    public function query()
    {
        $items = Item::search($this->searchQuery)
            ->select(
                'items.name AS itemName',
                'item_categories.name AS categoryName',
                'brands.name AS brandName',
                'units.name AS unitName',
                'items.*',
            )
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
            ->when($this->unitPriceFrom && $this->unitPriceTo != '', function ($query) {
                $query->whereBetween('unit_price', [$this->unitPriceFrom, $this->unitPriceTo]);
            })
            ->when($this->priceAFrom && $this->priceATo != '', function ($query) {
                $query->whereBetween('price_A', [$this->priceAFrom, $this->priceATo]);
            })
            ->when($this->priceBFrom && $this->priceBTo != '', function ($query) {
                $query->whereBetween('price_B', [$this->priceBFrom, $this->priceBTo]);
            });

        // order by for category relationship
        if ($this->sortBy == 'category') {
            $items = $items->orderBy('item_categories.name', $this->sortDirection);
        } elseif ($this->sortBy == 'brand') {
            $items = $items->orderBy('brands.name', $this->sortDirection);
        } elseif ($this->sortBy == 'unit') {
            $items = $items->orderBy('units.name', $this->sortDirection);
        } else {
            $items = $items->orderBy($this->sortBy, $this->sortDirection);
        }

        return $items;
    }
}
