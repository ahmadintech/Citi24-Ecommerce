<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'prod_id', 'qty', 'price', 'total'];
   
    public function product()
    {
        return $this->belongsTo(product::class, 'prod_id');
    }

    // Optionally, define the order relationship too:
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
