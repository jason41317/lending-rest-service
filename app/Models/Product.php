<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = ['id'];
    protected $appends = ['mark_up_percent'];

    public function getMarkUpPercentAttribute()
    {
        return number_format(($this->price / $this->cost) - 1, 5);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function getInventoryCountAttribute()
    {
        $inventories = $this->inventories;
        return $inventories->where('type', 'IN')->count() - $inventories->where('type', 'OUT')->count();
    }
}
