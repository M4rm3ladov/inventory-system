<?php

namespace App\Livewire;

use App\Exports\StockCountsExport;
use App\Models\Brand;
use App\Models\ItemCategory;
use App\Models\StockCount;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class AllStockCounts extends Component
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
    public $periodFrom = '';

    #[Url(history: 'true')]
    public $periodTo = '';

    #[Url(history: 'true')]
    public $dateFrom = '';

    #[Url(history: 'true')]
    public $dateTo = '';

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
        $this->periodFrom = '';
        $this->periodTo = '';
        $this->dateFrom = '';
        $this->dateTo = '';
    }

    public function filterChange()
    {
        $this->updatedSearchQuery();
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

    #[Computed()]
    public function stockCounts()
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
                ->whereDate('period_to', '<=' , $this->periodTo);
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

        // add pagination
        $stockCounts = $stockCounts->paginate($this->pagination);

        return $stockCounts;
    }

    #[On('refresh-stock-count')]
    public function render()
    {
        return view('livewire.all-stock-counts');
    }

    public function exportPdf()
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
                ->whereDate('period_to', '<=' , $this->periodTo);
            })
            ->where('inventories.branch_id', '=', Auth::user()->branch_id)
            ->get()
            ->toArray();

        $pdf = Pdf::loadView('product-stock.stock-count.stock-counts-pdf', ['stockCounts' => $stockCounts]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'stockCounts.pdf');
    }

    public function exportExcel()
    {
        return (new StockCountsExport(
            $this->searchQuery,
            $this->sortBy,
            $this->sortDirection,
            $this->category,
            $this->brand,
            $this->unit,
            $this->periodFrom,
            $this->periodTo,
            $this->dateFrom,
            $this->dateTo,
        ))->download('stockCounts.xls');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
