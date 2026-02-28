<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'stock',
        'description',
        'image',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage(){
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
}
