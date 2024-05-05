<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Inventory;
use App\Models\ItemCategory;
use App\Models\Unit;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Lazy()]
class AllInventories extends Component
{
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
    }

    public function filterChange()
    {
        $this->updatedSearchQuery();
    }

    #[Computed()]
    public function inventories()
    {
        $inventories = Inventory::search($this->searchQuery)
            ->select(
                'branches.name AS branchName',
                'items.name AS itemName',
                'item_categories.name AS categoryName',
                'brands.name AS brandName',
                'units.name AS unitName',
                'items.*',
            )
            ->join('items', 'inventories.item_id', '=', 'items.id')
            ->join('branches', 'inventories.branch_id', '=', 'branches.id')
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
            });

        // order by for category relationship
        if ($this->sortBy == 'category') {
            $inventories = $inventories->orderBy('item_categories.name', $this->sortDirection);
        } elseif ($this->sortBy == 'brand') {
            $inventories = $inventories->orderBy('brands.name', $this->sortDirection);
        } elseif ($this->sortBy == 'unit') {
            $inventories = $inventories->orderBy('units.name', $this->sortDirection);
        } else {
            $inventories = $inventories->orderBy($this->sortBy, $this->sortDirection);
        }

        // add pagination
        $inventories = $inventories->paginate($this->pagination);

        return $inventories;
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

    public function render()
    {
        return view('livewire.all-inventories');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
