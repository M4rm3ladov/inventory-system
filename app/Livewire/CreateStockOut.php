<?php

namespace App\Livewire;

use App\Livewire\Forms\StockOutForm;
use App\Models\Inventory;
use App\Models\StockOut;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateStockOut extends Component
{
    public StockOutForm $form;
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
        $this->dispatch('populate-item-search', $details);
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
        $this->dispatch('reset-item-search');
    }

    #[On('reset-modal')]
    public function close() {
        $this->resetInputs();
        $this->form->isEditing = $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.create-stock-out');
    }
}
