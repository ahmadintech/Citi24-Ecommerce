<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{

    protected $fillable = ['rating'];

    public function scopeFilter($query, array $filters)
    {
        if ($filters['product_name'] ?? false) {
            $query->where('product_name', 'like', '%' . request('tag') . '%');
        }
    }

    public function category()
    {
        return $this->belongsTo('App\Models\category', 'category_id');
    }

    public function attributes()
    {
        return $this->hasMany('App\Models\productAttribute', 'product_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'id');
    }

    public function cart()
    {
        return $this->hasMany('App\Models\Cart', 'prod_id');
    }

    public function images()
    {
        return $this->hasMany('App\Models\productsImage');
    }

    public function firstImage()
    {
        return $this->hasOne(productsImage::class)->orderBy('id', 'asc');
    }

    public function getMainImageAttribute()
    {
        return $this->firstImage
            ? asset('storage/product_images/small/' . $this->firstImage->image)
            : asset('no_image.png');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
