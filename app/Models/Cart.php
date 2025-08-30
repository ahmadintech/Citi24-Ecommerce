<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    public $timestamps = false; // Disable timestamps
     protected $fillable = [
        'user_id',
        'prod_id',
        'qty',
    ];


    public function product()
    {
        return $this->belongsTo('App\Models\product', 'prod_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function addresses()
    {
        return $this->belongsTo('App\Models\addresses', 'user_id');
    }
}
