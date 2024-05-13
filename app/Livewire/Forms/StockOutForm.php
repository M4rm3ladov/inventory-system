<?php

namespace App\Livewire\Forms;

use App\Models\StockOut;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StockOutForm extends Form
{
    public ?StockOut $stockOut;
    public $isEditing = false;

    public $inventory_id = -1;

    #[Validate('required|exists:items,id', as: 'item')]    
    public $item_id = -1;

    #[Validate('required|integer|min:1')]
    public $quantity;

    public $prevQuantity;
    
    #[Validate('nullable')]
    public $remarks = '';
    
    #[Validate('required|date')]
    public $transact_date;

    public function setStockOut($id)
    {
        $this->stockOut = StockOut::findOrfail($id);

        $this->item_id = $this->stockOut->item->id;
        $this->inventory_id = $this->stockOut->inventory_id;
        $this->prevQuantity = $this->quantity = $this->stockOut->quantity; 
        $this->remarks = $this->stockOut->remarks;
        $this->transact_date = Carbon::parse($this->transact_date)->format('Y-m-d');
    }

    public function resetInputs()
    {
        $this->reset();
        $this->transact_date = now()->toDateString('yyyy-mm-dd');
        $this->resetValidation();
    }
}
