<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'code',
        'description',
        'image',
        'price_A',
        'price_B',
    ];

    public function service_categories() {
        return $this->hasOne(ServiceCategory::class);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%");
    }
}
