<?php

namespace App\Livewire;

use App\Livewire\Forms\StockCountForm;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\StockCount;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateStockCount extends Component
{
    public StockCountForm $form;
    public $isEditing = false;

    #[Validate('required')]
    public $item_search = '';

    public $items = [];

    public function mount() {
        $this->form->transact_date = now()->toDateString('yyyy-mm-dd');
        $this->form->period_from = now()->toDateString('yyyy-mm-dd');
        $this->form->period_to = now()->toDateString('yyyy-mm-dd');
    }

    public function store() {
        $this->validate();
        
        // create new or update if existing
        $inventory = Inventory::firstOrNew([
            'item_id' => $this->form->item_id,
            'branch_id' => Auth::user()->branch_id,
        ],
        [
            'item_id' => $this->form->item_id,
            'branch_id' => Auth::user()->branch_id,
        ]);
        
        $inventory->quantity = $this->form->quantity;
        $inventory->save();
        $this->form->inventory_id = $inventory->id;

        StockCount::create($this->form->all());

        $this->dispatch('stock-count-created', [
            'title' => 'Success!',
            'text' => 'Stock Adjust record saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-stock-count')->to(AllStockCounts::class);
    }

    public function update() {
        $this->validate();

        // reset the item count in inventory before updating with new value
        $inventory = Inventory::findOrfail($this->form->inventory_id);
        $inventory->quantity = $this->form->quantity;
        $inventory->save();

        $this->form->stockCount->update(
            $this->form->all()
        );

        $this->dispatch('stock-count-created', [
            'title' => 'Success!',
            'text' => 'Stock Adjust record saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('stock-count-updated');
        $this->dispatch('refresh-stock-count')->to(AllStockCounts::class);
    }

    #[On('stock-count-edit')]
    public function edit($id, $details)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setStockCount($id);
        $itemDetails = "{$details['code']} | {$details['itemName']} {$details['description']} | {$details['brandName']} " .
            "| {$details['categoryName']} | {$details['unitName']}";
        $this->item_search = $itemDetails;
    }

    #[On('stock-count-delete')]
    public function delete($id, $quantity, $inventory_id) {
        $stockCount = StockCount::findOrfail($id);
        $stockCount->delete();
        
        $this->dispatch('stock-count-deleted');
        $this->dispatch('refresh-stock-count')->to(AllStockCounts::class);
    }

    public function resetInputs() {
        $this->form->resetInputs();
        $this->item_search = '';
        $this->resetValidation();
    }

    #[On('reset-modal')]
    public function close() {
        $this->resetInputs();
        $this->form->isEditing = $this->isEditing = false;
    }

    #[Computed()]
    public function suppliers()
    {
        return Supplier::orderBy('name', 'ASC')->get();
    }

    public function updatedItemSearch()
    {
        $this->form->item_id = -1;
        if (empty($this->item_search)) $this->items = [];

        $this->items = Item::search($this->item_search)
            ->orWhere('item_categories.name', 'like', "%{$this->item_search}%")
            ->orWhere('brands.name', 'like', "%{$this->item_search}%")
            ->orWhere('units.name', 'like', "%{$this->item_search}%")
            ->orWhere(
                DB::raw("CONCAT(items.code, ' | ', 
                items.name, ' ', 
                items.description, ' | ', 
                brands.name, ' | ', 
                item_categories.name, ' | ', 
                units.name)"),
                'like',
                "%{$this->item_search}%"
            )
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
            ->get()
            ->toArray();

        foreach ($this->items as $item) {
            if ($item['details'] == $this->item_search) {
                $this->form->item_id = $item['id'];
            }
        }
    }

    public function populateItem($id, $details)
    {
        $this->form->item_id = $id;
        $this->item_search = $details;
        $this->items = [];
    }

    public function resetItemSearch()
    {
        $this->items = [];
    }

    public function render()
    {
        return view('livewire.create-stock-count');
    }
}
