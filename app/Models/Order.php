<?php

namespace App\Models;

use App\Models\User;
use App\Models\addresses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'order_number',
        'shipping_charge',
        'grand_total',
        'order_status',
        'payment_status',
        'track_order',
    ];



    public function product()
    {
        return $this->belongsTo(product::class, 'prod_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function addresses()
    // {
    //     return $this->belongsTo(addresses::class, 'user_id');
    // }

    public function addresses()
    {
        return $this->belongsTo(addresses::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


}
