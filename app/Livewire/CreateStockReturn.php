<?php

namespace App\Livewire;

use App\Livewire\Forms\StockReturnForm;
use App\Models\Inventory;
use App\Models\StockReturn;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateStockReturn extends Component
{
    public StockReturnForm $form;
    public $isEditing = false;

    #[On('populate-item-id')]
    public function populateId($id) {
        $this->form->item_id = $id;
    }

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

        StockReturn::create($this->form->all());

        $this->dispatch('stock-return-created', [
            'title' => 'Success!',
            'text' => 'Stock in record saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-stock-return')->to(AllStockReturns::class);
    }

    public function update() {
        $this->validate();

        // reset the item count in inventory before updating with new value
        $inventory = Inventory::findOrfail($this->form->inventory_id);
        $inventory->quantity += $this->form->prevQuantity - $this->form->quantity;
        $inventory->save();

        $this->form->stockReturn->update(
            $this->form->all()
        );

        $this->dispatch('stock-return-created', [
            'title' => 'Success!',
            'text' => 'Stock in record saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('stock-return-updated');
        $this->dispatch('refresh-stock-return')->to(AllStockReturns::class);
    }

    #[On('stock-return-edit')]
    public function edit($id, $details)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setStockReturn($id);
        $this->dispatch('populate-item-search', $details);
    }

    #[On('stock-return-delete')]
    public function delete($id, $quantity, $inventory_id) {
        // decrement inventory item count
        $inventory = Inventory::findOrFail($inventory_id);
        $inventory->quantity += $quantity;
        $inventory->save();

        $stockReturn = StockReturn::findOrfail($id);
        $stockReturn->delete();
        
        $this->dispatch('stock-return-deleted');
        $this->dispatch('refresh-stock-return')->to(AllStockReturns::class);
    }

    public function resetInputs() {
        $this->form->resetInputs();
        $this->dispatch('reset-item-search');
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

    public function render()
    {
        return view('livewire.create-stock-return');
    }
}
