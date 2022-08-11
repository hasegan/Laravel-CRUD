<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
    protected $fillable = ['product_id', 'quantity'];
    use HasFactory;

    function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
