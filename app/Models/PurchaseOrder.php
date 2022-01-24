<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'purchase_order_products', 'purchase_order_id', 'product_id')
            ->withPivot('cost', 'qty');
    }
}
