<?php

namespace App\Livewire\Forms;

use App\Models\StockIn;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StockInForm extends Form
{
    public ?StockIn $stockIn;
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

    public function setStockIn($id)
    {
        $this->stockIn = StockIn::findOrfail($id);

        $this->item_id = $this->stockIn->item->id;
        $this->inventory_id = $this->stockIn->inventory_id;
        $this->supplier_id = $this->stockIn->supplier_id;
        $this->prevQuantity = $this->quantity = $this->stockIn->quantity; 
        $this->remarks = $this->stockIn->remarks;
        $this->transact_date = Carbon::parse($this->transact_date)->format('Y-m-d');
    }

    public function resetInputs()
    {
        $this->reset();
        $this->transact_date = now()->toDateString('yyyy-mm-dd');
        $this->resetValidation();
    }
}
