<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'name'
    ];

    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%");
    }
}
