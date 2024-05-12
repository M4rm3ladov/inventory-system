<?php

namespace App\Livewire;

use App\Exports\StockOutsExport;
use App\Models\Brand;
use App\Models\ItemCategory;
use App\Models\StockOut;
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
class AllStockOuts extends Component
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
    public function stockOuts()
    {
        $stockOuts = StockOut::search($this->searchQuery)
            ->select(
                'items.name AS itemName',
                'item_categories.name AS categoryName',
                'brands.name AS brandName',
                'units.name AS unitName',
                'items.*',
                'stock_outs.created_at AS createdAt',
                'stock_outs.updated_at AS updatedAt',
                'stock_outs.*'
            )
            ->join('inventories', 'stock_outs.inventory_id', '=', 'inventories.id')
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
            ->where('inventories.branch_id', '=', Auth::user()->branch_id);

        // order by for category relationship
        if ($this->sortBy == 'category') {
            $stockOuts = $stockOuts->orderBy('item_categories.name', $this->sortDirection);
        } elseif ($this->sortBy == 'brand') {
            $stockOuts = $stockOuts->orderBy('brands.name', $this->sortDirection);
        } elseif ($this->sortBy == 'unit') {
            $stockOuts = $stockOuts->orderBy('units.name', $this->sortDirection);
        } else if ($this->sortBy == 'transaction_date') {
            $stockOuts = $stockOuts->orderBy('transact_date', $this->sortDirection);
        } else if ($this->sortBy == 'created_at') {
            $stockOuts = $stockOuts->orderBy('stock_outs.created_at', $this->sortDirection);
        } else if ($this->sortBy == 'updated_at') {
            $stockOuts = $stockOuts->orderBy('stock_outs.updated_at', $this->sortDirection);
        } else {
            $stockOuts = $stockOuts->orderBy($this->sortBy, $this->sortDirection);
        }

        // add pagination
        $stockOuts = $stockOuts->paginate($this->pagination);

        return $stockOuts;
    }

    #[On('refresh-stock-out')]
    public function render()
    {
        return view('livewire.all-stock-outs');
    }

    public function exportPdf()
    {
        $stockOuts = StockOut::search($this->searchQuery)
            ->select(
                'items.name AS itemName',
                'item_categories.name AS categoryName',
                'brands.name AS brandName',
                'units.name AS unitName',
                'items.*',
                'stock_outs.created_at AS createdAt',
                'stock_outs.updated_at AS updatedAt',
                'stock_outs.*'
            )
            ->join('inventories', 'stock_outs.inventory_id', '=', 'inventories.id')
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
            ->where('inventories.branch_id', '=', Auth::user()->branch_id)
            ->get()
            ->toArray();

        $pdf = Pdf::loadView('product-stock.stock-out.stock-outs-pdf', ['stockOuts' => $stockOuts]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'stockOuts.pdf');
    }

    public function exportExcel()
    {
        return (new StockOutsExport(
            $this->searchQuery,
            $this->sortBy,
            $this->sortDirection,
            $this->category,
            $this->brand,
            $this->unit,
            $this->dateFrom,
            $this->dateTo,
        ))->download('stockOuts.xls');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
