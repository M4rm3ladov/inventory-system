<?php

namespace App\Livewire\Forms;

use App\Models\StockCount;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StockCountForm extends Form
{
    public ?StockCount $stockCount;
    public $isEditing = false;

    public $inventory_id = -1;

    #[Validate('required|exists:items,id', as: 'item')]    
    public $item_id = -1;

    #[Validate('required|integer|min:1')]
    public $quantity;
    
    #[Validate('nullable')]
    public $remarks = '';
    
    #[Validate('required|date')]
    public $transact_date;
    
    #[Validate('required|date')]
    public $period_from;
    
    #[Validate('required|date|after_or_equal:period_from')]
    public $period_to;

    public function setStockCount($id)
    {
        $this->stockCount = StockCount::findOrfail($id);

        $this->item_id = $this->stockCount->item->id;
        $this->inventory_id = $this->stockCount->inventory_id;
        $this->quantity = $this->stockCount->quantity;
        $this->remarks = $this->stockCount->remarks;
        $this->transact_date = Carbon::parse($this->transact_date)->format('Y-m-d');
        $this->period_from = Carbon::parse($this->period_from)->format('Y-m-d');
        $this->period_to = Carbon::parse($this->period_to)->format('Y-m-d');
    }

    public function resetInputs()
    {
        $this->reset();
        $this->transact_date = now()->toDateString('yyyy-mm-dd');
        $this->period_from = now()->toDateString('yyyy-mm-dd');
        $this->period_to = now()->toDateString('yyyy-mm-dd');
        $this->resetValidation();
    }
}
