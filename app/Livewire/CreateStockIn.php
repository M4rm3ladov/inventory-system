<?php

namespace App\Livewire;

use App\Livewire\Forms\StockInForm;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\StockIn;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateStockIn extends Component
{
    public StockInForm $form;
    public $isEditing = false;

    #[Validate('required')]
    public $item_search = '';

    public $items = [];

    public function mount() {
        $this->form->transact_date = now()->toDateString('yyyy-mm-dd');
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
        
        $inventory->quantity = $inventory->quantity + $this->form->quantity;
        $inventory->save();
        $this->form->inventory_id = $inventory->id;

        StockIn::create($this->form->all());

        $this->dispatch('stock-in-created', [
            'title' => 'Success!',
            'text' => 'Stock in record saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-stock-in')->to(AllStockIns::class);
    }

    public function update() {
        $this->validate();

        // reset the item count in inventory before updating with new value
        $inventory = Inventory::findOrfail($this->form->inventory_id);
        $inventory->quantity = $inventory->quantity - $this->form->prevQuantity + $this->form->quantity;
        $inventory->save();

        $this->form->stockIn->update(
            $this->form->all()
        );

        $this->dispatch('stock-in-created', [
            'title' => 'Success!',
            'text' => 'Stock in record saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('stock-in-updated');
        $this->dispatch('refresh-stock-in')->to(AllStockIns::class);
    }

    #[On('stock-in-edit')]
    public function edit($id, $details)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setStockIn($id);
        $itemDetails = "{$details['code']} | {$details['itemName']} {$details['description']} | {$details['brandName']} " .
            "| {$details['categoryName']} | {$details['unitName']}";
        $this->item_search = $itemDetails;
    }

    #[On('stock-in-delete')]
    public function delete($id, $quantity, $inventory_id) {
        // decrement inventory item count
        $inventory = Inventory::findOrFail($inventory_id);
        $inventory->quantity -= $quantity;
        $inventory->save();

        $stockIn = StockIn::findOrfail($id);
        $stockIn->delete();
        
        $this->dispatch('stock-in-deleted');
        $this->dispatch('refresh-stock-in')->to(AllStockIns::class);
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
        return view('livewire.create-stock-in');
    }
}
