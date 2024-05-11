<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'inventory_id',
        'supplier_id',
        'quantity',
        'remarks',
        'transact_date'
    ];

    public function inventory() {
        return $this->belongsTo(Inventory::class);
    }

    public function item() {
        return $this->belongsToThrough(Item::class, Inventory::class);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('code', 'like', "%{$value}%")
            ->orWhere('items.name', 'like', "%{$value}%")
            ->orWhere('items.description', 'like', "%{$value}%");
    }
}
