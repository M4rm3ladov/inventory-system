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

    public function getTagNameAttribute()
    {
        return $this->attributes['name'];
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('code', 'like', "%{$value}%")
            ->orWhere('services.name', 'like', "%{$value}%");
    }
}
