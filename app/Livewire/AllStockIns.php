<?php

namespace App\Livewire;

use App\Exports\StockInsExport;
use App\Models\Brand;
use App\Models\ItemCategory;
use App\Models\StockIn;
use App\Models\Supplier;
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
class AllStockIns extends Component
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
    public $supplier = 'All';

    #[Url(history: 'true')]
    public $category = 'All';

    #[Url(history: 'true')]
    public $brand = 'All';

    #[Url(history: 'true')]
    public $unit = 'All';

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
        $this->supplier = 'All';
        $this->category = 'All';
        $this->brand = 'All';
        $this->unit = 'All';
        $this->dateFrom = '';
        $this->dateTo = '';
    }

    public function filterChange()
    {
        $this->updatedSearchQuery();
    }

    #[Computed()]
    public function suppliers()
    {
        return Supplier::orderBy('name', 'ASC')->get();
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
    public function stockIns()
    {
        $stockIns = StockIn::search($this->searchQuery)
            ->select(
                'suppliers.name AS supplierName',
                'items.name AS itemName',
                'item_categories.name AS categoryName',
                'brands.name AS brandName',
                'units.name AS unitName',
                'items.*',
                'stock_ins.created_at AS createdAt',
                'stock_ins.updated_at AS updatedAt',
                'stock_ins.*'
            )
            ->join('suppliers', 'stock_ins.supplier_id', '=', 'suppliers.id')
            ->join('inventories', 'stock_ins.inventory_id', '=', 'inventories.id')
            ->join('items', 'inventories.item_id', '=', 'items.id')
            ->join('item_categories', 'items.item_category_id', '=', 'item_categories.id')
            ->join('brands', 'items.brand_id', '=', 'brands.id')
            ->join('units', 'items.unit_id', '=', 'units.id')
            ->when($this->supplier != 'All', function ($query) {
                $query->where('suppliers.name', $this->supplier);
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
            $stockIns = $stockIns->orderBy('item_categories.name', $this->sortDirection);
        } elseif ($this->sortBy == 'brand') {
            $stockIns = $stockIns->orderBy('brands.name', $this->sortDirection);
        } elseif ($this->sortBy == 'unit') {
            $stockIns = $stockIns->orderBy('units.name', $this->sortDirection);
        } elseif ($this->sortBy == 'supplier') {
            $stockIns = $stockIns->orderBy('suppliers.name', $this->sortDirection);
        } else if ($this->sortBy == 'transaction_date') {
            $stockIns = $stockIns->orderBy('transact_date', $this->sortDirection);
        } else if ($this->sortBy == 'created_at') {
            $stockIns = $stockIns->orderBy('stock_ins.created_at', $this->sortDirection);
        } else if ($this->sortBy == 'updated_at') {
            $stockIns = $stockIns->orderBy('stock_ins.updated_at', $this->sortDirection);
        } else {
            $stockIns = $stockIns->orderBy($this->sortBy, $this->sortDirection);
        }

        // add pagination
        $stockIns = $stockIns->paginate($this->pagination);

        return $stockIns;
    }

    #[On('refresh-stock-in')]
    public function render()
    {
        return view('livewire.all-stock-ins');
    }

    public function exportPdf()
    {
        $stockIns = StockIn::search($this->searchQuery)
            ->select(
                'suppliers.name AS supplierName',
                'items.name AS itemName',
                'item_categories.name AS categoryName',
                'brands.name AS brandName',
                'units.name AS unitName',
                'items.*',
                'stock_ins.created_at AS createdAt',
                'stock_ins.updated_at AS updatedAt',
                'stock_ins.*'
            )
            ->join('suppliers', 'stock_ins.supplier_id', '=', 'suppliers.id')
            ->join('inventories', 'stock_ins.inventory_id', '=', 'inventories.id')
            ->join('items', 'inventories.item_id', '=', 'items.id')
            ->join('item_categories', 'items.item_category_id', '=', 'item_categories.id')
            ->join('brands', 'items.brand_id', '=', 'brands.id')
            ->join('units', 'items.unit_id', '=', 'units.id')
            ->when($this->supplier != 'All', function ($query) {
                $query->where('suppliers.name', $this->supplier);
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
            ->where('inventories.branch_id', '=', Auth::user()->branch_id)
            ->get()
            ->toArray();

        $pdf = Pdf::loadView('product-stock.stock-in.stock-ins-pdf', ['stockIns' => $stockIns]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'stockIns.pdf');
    }

    public function exportExcel()
    {
        return (new StockInsExport(
            $this->searchQuery,
            $this->sortBy,
            $this->sortDirection,
            $this->supplier,
            $this->category,
            $this->brand,
            $this->unit,
            $this->dateFrom,
            $this->dateTo,
        ))->download('stockIns.xls');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
