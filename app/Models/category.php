<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    public function subCategories()
    {
        return $this->hasMany('App\Models\category', 'parent_id')->where('status', 1);
    }

    public function parentCategory()
    {
        return $this->belongsTo('App\Models\category', 'parent_id')->select('id', 'name');
    }
}
