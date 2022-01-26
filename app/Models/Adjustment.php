<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adjustment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function products()
    {
        return $this->morphToMany(Product::class, 'inventoriable', 'inventories', 'inventoriable_id', 'product_id')
            ->withPivot('cost', 'quantity');
    }
}
