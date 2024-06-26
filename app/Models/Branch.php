<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    //protected $guarded = [];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    public function inventories() {
        return $this->hasMany(Inventory::class, 'branch_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'branch_id', 'id');
    }

    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('address', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%")
            ->orWhere('phone', 'like', "%{$value}%");
    }
}
