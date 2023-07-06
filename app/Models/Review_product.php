<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;

class Review_product extends Model
{
    use HasFactory;

    public function review()
    {
        return $this->belongsTo(Product::class, 'product_id' , 'id');
    }
}