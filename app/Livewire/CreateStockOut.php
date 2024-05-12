<?php

namespace App\Livewire;

use App\Livewire\Forms\StockOutForm;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\StockOut;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateStockOut extends Component
{
    public StockOutForm $form;
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
        
        $inventory->quantity -= $this->form->quantity;
        $inventory->save();
        $this->form->inventory_id = $inventory->id;

        StockOut::create($this->form->all());

        $this->dispatch('stock-out-created', [
            'title' => 'Success!',
            'text' => 'Stock out record saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-stock-out')->to(AllStockOuts::class);
    }

    public function update() {
        $this->validate();

        // reset the item count in inventory before updating with new value
        $inventory = Inventory::findOrfail($this->form->inventory_id);
        $inventory->quantity += $this->form->prevQuantity - $this->form->quantity;
        $inventory->save();

        $this->form->stockOut->update(
            $this->form->all()
        );

        $this->dispatch('stock-out-created', [
            'title' => 'Success!',
            'text' => 'Stock out record saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('stock-out-updated');
        $this->dispatch('refresh-stock-out')->to(AllStockOuts::class);
    }

    #[On('stock-out-edit')]
    public function edit($id, $details)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setStockOut($id);
        $itemDetails = "{$details['code']} | {$details['itemName']} {$details['description']} | {$details['brandName']} " .
            "| {$details['categoryName']} | {$details['unitName']}";
        $this->item_search = $itemDetails;
    }

    #[On('stock-out-delete')]
    public function delete($id, $quantity, $inventory_id) {
        // decrement inventory item count
        $inventory = Inventory::findOrFail($inventory_id);
        $inventory->quantity += $quantity;
        $inventory->save();

        $stockOut = StockOut::findOrfail($id);
        $stockOut->delete();
        
        $this->dispatch('stock-out-deleted');
        $this->dispatch('refresh-stock-out')->to(AllStockOuts::class);
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
        return view('livewire.create-stock-out');
    }
}
