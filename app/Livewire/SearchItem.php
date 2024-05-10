<?php

namespace App\Livewire;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SearchItem extends Component
{
    #[Validate('required')]
    public $searchQuery = '';

    #[Computed()]
    public function items()
    {
        $items = Item::search($this->searchQuery)
            ->select(
                DB::raw("CONCAT(items.code, ' | ', 
                items.name, ' ', 
                items.description, ' | ', 
                brands.name, ' | ', 
                item_categories.name, ' | ', 
                units.name) AS details"),
                'items.id'
            )
            ->join('item_categories', 'items.item_category_id', '=', 'item_categories.id')
            ->join('brands', 'items.brand_id', '=', 'brands.id')
            ->join('units', 'items.unit_id', '=', 'units.id')
            ->get();
        return $items;
    }

    #[On('reset-item-search')]
    public function resetSearch() {
        $this->reset();
    }

    #[On('populate-item-search')]
    public function populateItemSearch($details) {
        $itemDetails = $details['code'] . ' | ' . $details['itemName'] . $details['description'] . ' | ' 
        . $details['brandName'] . ' | '. $details['categoryName'] . ' | ' . $details['unitName'];
        $this->searchQuery = $itemDetails;
    }

    public function populateItem($item) {
        $this->searchQuery = $item['details'];
        $id = $item['id'];
        $this->dispatch('populate-item-id', $id);
    }

    public function render()
    {
        return view('livewire.search-item');
    }
}
