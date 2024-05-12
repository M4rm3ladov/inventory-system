<?php

namespace App\Livewire\Forms;

use App\Models\StockTransfer;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StockTransferForm extends Form
{
    public ?StockTransfer $stockTransfer;
    public $isEditing = false;

    public $inventory_id = -1;

    #[Validate('exists:items,id', as: 'item')]    
    public $item_id = -1;

    #[Validate('integer|min:1')]
    public $quantity;

    public $prevQuantity;

    #[Validate('exists:branches,id', as: 'branch')]
    public $branch_id_to = -1;
    
    #[Validate('nullable')]
    public $remarks = '';
    
    #[Validate('required|date')]
    public $transact_date;

    public function setstockTransfer($id)
    {
        $this->stockTransfer = StockTransfer::findOrfail($id);

        $this->item_id = $this->stockTransfer->item->id;
        $this->inventory_id = $this->stockTransfer->inventory_id;
        $this->branch_id_to = $this->stockTransfer->branch_id_to;
        $this->prevQuantity = $this->quantity = $this->stockTransfer->quantity; 
        $this->remarks = $this->stockTransfer->remarks;
        $this->transact_date = Carbon::parse($this->transact_date)->format('Y-m-d');
    }

    public function resetInputs()
    {
        $this->reset();
        $this->transact_date = now()->toDateString('yyyy-mm-dd');
        $this->resetValidation();
    }
}
