<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productAttribute extends Model
{
    public function product(){
        return $this->belongsTo('App\Models\product', 'product_id');
    }
}
