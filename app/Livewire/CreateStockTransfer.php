<?php

namespace App\Livewire;

use App\Livewire\Forms\StockTransferForm;
use App\Models\Branch;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\StockTransfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateStockTransfer extends Component
{
    public StockTransferForm $form;
    public $isEditing = false;

    #[Validate('required')]
    public $item_search = '';

    public $items = [];

    public function mount()
    {
        $this->form->transact_date = now()->toDateString('yyyy-mm-dd');
    }

    public function store()
    {
        $this->validate();

        // create new or update if existing
        $inventoryFrom = Inventory::firstOrNew(
            [
                'item_id' => $this->form->item_id,
                'branch_id' => Auth::user()->branch_id,
            ],
            [
                'item_id' => $this->form->item_id,
                'branch_id' => Auth::user()->branch_id,
            ]
        );

        $inventoryTo = Inventory::firstOrNew(
            [
                'item_id' => $this->form->item_id,
                'branch_id' => $this->form->branch_id_to,
            ],
            [
                'item_id' => $this->form->item_id,
                'branch_id' => $this->form->branch_id_to,
            ]
        );

        $inventoryTo->quantity += $this->form->quantity;
        $inventoryTo->save();
        $inventoryFrom->quantity -= $this->form->quantity;
        $inventoryFrom->save();

        $this->form->inventory_id = $inventoryFrom->id;

        StockTransfer::create($this->form->all());

        $this->dispatch('stock-transfer-created', [
            'title' => 'Success!',
            'text' => 'Stock transfer record saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-stock-transfer')->to(AllStockTransfers::class);
    }

    public function update()
    {
        $this->validate();

        $this->form->stockTransfer->update(
            $this->form->all()
        );
        // reset the item count in inventory before updating with new value
        $inventoryFrom = Inventory::findOrfail($this->form->inventory_id);
        $inventoryFrom->quantity += $this->form->prevQuantity - $this->form->quantity;
        $inventoryFrom->save();

        $inventoryTo = Inventory::where('item_id', '=', $this->form->item_id)
            ->where('branch_id', '=', $this->form->branch_id_to)
            ->firstOrFail();
        $inventoryTo->quantity -= $this->form->prevQuantity - $this->form->quantity;
        $inventoryTo->save();

        $this->dispatch('stock-transfer-created', [
            'title' => 'Success!',
            'text' => 'Stock transfer record saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('stock-transfer-updated');
        $this->dispatch('refresh-stock-transfer')->to(AllStockTransfers::class);
    }

    #[On('stock-transfer-edit')]
    public function edit($id, $details)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setStockTransfer($id);
        $itemDetails = "{$details['code']} | {$details['itemName']} {$details['description']} | {$details['brandName']} " .
            "| {$details['categoryName']} | {$details['unitName']}";
        $this->item_search = $itemDetails;
    }

    #[On('stock-transfer-delete')]
    public function delete($id, $branch_id_to, $item_id, $quantity, $inventory_id)
    {
        // decrement inventory item count
        $inventoryFrom = Inventory::findOrFail($inventory_id);
        $inventoryFrom->quantity += $quantity;
        $inventoryFrom->save();

        $inventoryTo = Inventory::where('item_id', '=', $item_id)
            ->where('branch_id', '=', $branch_id_to)
            ->firstOrFail();
        $inventoryTo->quantity -= $quantity;
        $inventoryTo->save();

        $stockTransfer = StockTransfer::findOrfail($id);
        $stockTransfer->delete();

        $this->dispatch('stock-transfer-deleted');
        $this->dispatch('refresh-stock-transfer')->to(AllStockTransfers::class);
    }

    public function resetInputs()
    {
        $this->form->resetInputs();
        $this->item_search = '';
        $this->resetValidation();
    }

    #[On('reset-modal')]
    public function close()
    {
        $this->resetInputs();
        $this->form->isEditing = $this->isEditing = false;
    }

    #[Computed()]
    public function branches()
    {
        return Branch::orderBy('name', 'ASC')->get();
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
        return view('livewire.create-stock-transfer');
    }
}
