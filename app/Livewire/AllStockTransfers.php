<?php

namespace App\Livewire;

use App\Exports\StockTransfersExport;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\ItemCategory;
use App\Models\StockTransfer;
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
class AllStockTransfers extends Component
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
    public $branchTo = 'All';

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
        $this->branchTo = 'All';
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
    public function branches()
    {
        return Branch::orderBy('name', 'ASC')->get();
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
    public function stockTransfers()
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

        // add pagination
        $stockTransfers = $stockTransfers->paginate($this->pagination);

        return $stockTransfers;
    }

    #[On('refresh-stock-transfer')]
    public function render()
    {
        return view('livewire.all-stock-transfers');
    }

    // public function exportPdf()
    // {
    //     $stockTransfers = StockTransfer::search($this->searchQuery)
    //         ->select(
    //             'branches.name AS branchTo',
    //             'items.name AS itemName',
    //             'item_categories.name AS categoryName',
    //             'brands.name AS brandName',
    //             'units.name AS unitName',
    //             'items.*',
    //             'stock_transfers.created_at AS createdAt',
    //             'stock_transfers.updated_at AS updatedAt',
    //             'stock_transfers.*'
    //         )
    //         ->join('branches', 'stock_transfers.branch_id_to', '=', 'branches.id')
    //         ->join('inventories', 'stock_transfers.inventory_id', '=', 'inventories.id')
    //         ->join('items', 'inventories.item_id', '=', 'items.id')
    //         ->join('item_categories', 'items.item_category_id', '=', 'item_categories.id')
    //         ->join('brands', 'items.brand_id', '=', 'brands.id')
    //         ->join('units', 'items.unit_id', '=', 'units.id')
    //         ->when($this->branchTo != 'All', function ($query) {
    //             $query->where('branches.name', $this->branchTo);
    //         })
    //         ->when($this->category != 'All', function ($query) {
    //             $query->where('item_categories.name', $this->category);
    //         })
    //         ->when($this->brand != 'All', function ($query) {
    //             $query->where('brands.name', $this->brand);
    //         })
    //         ->when($this->unit != 'All', function ($query) {
    //             $query->where('units.name', $this->unit);
    //         })
    //         ->when($this->dateFrom && $this->dateTo != '', function ($query) {
    //             $query->whereBetween('transact_date', [$this->dateFrom, $this->dateTo]);
    //         })
    //         ->where('inventories.branch_id', '=', Auth::user()->branch_id)
    //         ->get()
    //         ->toArray();

    //     $pdf = Pdf::loadView('product-stock.stock-transfer.stock-transfers-pdf', ['stockTransfers' => $stockTransfers]);

    //     return response()->streamDownload(function () use ($pdf) {
    //         echo $pdf->stream();
    //     }, 'stockTransfers.pdf');
    // }

    // public function exportExcel()
    // {
    //     return (new StockTransfersExport(
    //         $this->searchQuery,
    //         $this->sortBy,
    //         $this->sortDirection,
    //         $this->branchTo,
    //         $this->category,
    //         $this->brand,
    //         $this->unit,
    //         $this->dateFrom,
    //         $this->dateTo,
    //     ))->download('stockTransfers.xls');
    // }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
