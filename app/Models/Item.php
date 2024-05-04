<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $with = ['itemCategory:id,name', 'brand:id,name', 'unit:id,name'];

    protected $fillable = [
        'code',
        'name',
        'description',
        'item_category_id',
        'brand_id',
        'unit_id',
        'image',
        'unit_price',
        'price_A',
        'price_B',
    ];

    public function itemCategory()
    {
        return $this->belongsTo(itemCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('code', 'like', "%{$value}%")
            ->orWhere('items.name', 'like', "%{$value}%")
            ->orWhere('items.description', 'like', "%{$value}%");
    }
}
