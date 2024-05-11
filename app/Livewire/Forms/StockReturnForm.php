<?php

namespace App\Livewire\Forms;

use App\Models\Inventory;
use App\Models\StockReturn;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StockReturnForm extends Form
{
    public ?StockReturn $stockReturn;
    public $isEditing = false;

    public $inventory_id = -1;

    #[Validate('exists:items,id', as: 'item')]    
    public $item_id = -1;

    #[Validate('integer|min:1')]
    public $quantity;

    public $prevQuantity;

    #[Validate('exists:suppliers,id', as: 'supplier')]
    public $supplier_id = -1;
    
    #[Validate('nullable')]
    public $remarks = '';
    
    #[Validate('required|date')]
    public $transact_date;

    public function setStockReturn($id)
    {
        $this->stockReturn = StockReturn::findOrfail($id);

        $this->item_id = $this->stockReturn->item->id;
        $this->inventory_id = $this->stockReturn->inventory_id;
        $this->supplier_id = $this->stockReturn->supplier_id;
        $this->prevQuantity = $this->quantity = $this->stockReturn->quantity; 
        $this->remarks = $this->stockReturn->remarks;
        $this->transact_date = Carbon::parse($this->transact_date)->format('Y-m-d');
    }

    public function resetInputs()
    {
        $this->reset();
        $this->transact_date = now()->toDateString('yyyy-mm-dd');
        $this->resetValidation();
    }
}
