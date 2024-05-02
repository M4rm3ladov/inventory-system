<?php

namespace App\Livewire;

use App\Exports\ItemsExport;
use App\Models\Brand;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class AllItems extends Component
{
    use WithPagination;

    #[Url(history: 'true')]
    public $searchQuery = '';

    #[Url()]
    public $pagination = 10;

    #[Url(history: 'true')]
    public $sortBy = 'created_at';

    #[Url(history: 'true')]
    public $sortDirection = 'DESC';

    #[Url(history: 'true')]
    public $category = 'All';

    #[Url(history: 'true')]
    public $brand = 'All';

    #[Url(history: 'true')]
    public $unit = 'All';

    #[Url(history: 'true')]
    public $unitPriceFrom = '';

    #[Url(history: 'true')]
    public $unitPriceTo = '';

    #[Url(history: 'true')]
    public $priceAFrom = '';

    #[Url(history: 'true')]
    public $priceATo = '';

    #[Url(history: 'true')]
    public $priceBFrom = '';

    #[Url(history: 'true')]
    public $priceBTo = '';

    public function placeholder()
    {
        return <<<'HTML'
            <div>
                <div class="placeholder-glow mb-2">
                    <div class="placeholder placeholder-lg col-2"></div>
                </div>
                <div>
                    <button class="btn btn-primary disabled placeholder col-2 mr-2">
                    <button class="btn btn-primary disabled placeholder col-2 mr-2">
                    <button class="btn btn-primary disabled placeholder col-2">
                </div>
                <div class="placeholder-glow">
                    <div class="placeholder placeholder-lg col-2"></div>
                    <div class="placeholder placeholder-lg col-12"></div>
                </div>
            </div>
        HTML;
    }

    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDirection = ($this->sortDirection == 'ASC') ? 'DESC' : 'ASC';
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDirection = 'DESC';
    }

    public function resetFilter()
    {
        $this->searchQuery = '';
        $this->sortBy = 'created_at';
        $this->category = 'All';
        $this->brand = 'All';
        $this->unit = 'All';
        $this->unitPriceFrom = '';
        $this->unitPriceTo = '';
        $this->priceAFrom = '';
        $this->priceATo = '';
        $this->priceBFrom = '';
        $this->priceBTo = '';
    }

    public function filterChange()
    {
        $this->updatedSearchQuery();
    }

    #[Computed()]
    public function items()
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

        // add pagination
        $items = $items->paginate($this->pagination);

        return $items;
    }

    #[Computed()]
    public function itemCategories()
    {
        return ItemCategory::orderBy('name', 'ASC')->get();
    }

    #[Computed()]
    public function brands()
    {
        return Brand::orderBy('name', 'ASC')->get();
    }

    #[Computed()]
    public function units()
    {
        return Unit::orderBy('name', 'ASC')->get();
    }

    #[On('refresh-item')]
    public function render()
    {
        return view('livewire.all-items');
    }

    public function exportPdf()
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
            })
            ->get()
            ->toArray();

        $pdf = Pdf::loadView('product.items-pdf', ['items' => $items]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'items.pdf');
    }

    public function exportExcel()
    {
        return (new ItemsExport(
            $this->searchQuery,
            $this->sortBy,
            $this->sortDirection,
            $this->category,
            $this->brand,
            $this->unit,
            $this->unitPriceFrom,
            $this->unitPriceTo,
            $this->priceAFrom,
            $this->priceATo,
            $this->priceBFrom,
            $this->priceBTo
        ))
            ->download('items.xls');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
