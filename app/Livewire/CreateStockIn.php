<?php

namespace App\Livewire;

use App\Livewire\Forms\StockInForm;
use App\Models\Inventory;
use App\Models\StockIn;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateStockIn extends Component
{
    public StockInForm $form;
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
        $this->dispatch('populate-item-search', $details);
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
        return view('livewire.create-stock-in');
    }
}
