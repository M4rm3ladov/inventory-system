<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'item_id',
        'branch_id',
        'quantity',
    ]; 

    public function stockIns() {
        return $this->hasMany(StockIn::class);
    }

    public function stockReturns() {
        return $this->hasMany(StockReturn::class);
    }

    public function itemCategory()
    {
        return $this->belongsToThrough(ItemCategory::class, Item::class);
    }
    
    public function brand()
    {
        return $this->belongsToThrough(Brand::class, Item::class);
    }

    public function unit()
    {
        return $this->belongsToThrough(Unit::class, Item::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('items.code', 'like', "%{$value}%")
            ->orWhere('items.name', 'like', "%{$value}%")
            ->orWhere('items.description', 'like', "%{$value}%");
    }
}
