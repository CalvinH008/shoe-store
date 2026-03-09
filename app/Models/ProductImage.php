<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary',
        'sort_order'
    ];

    protected $casts = [
        'product_id' => 'integer',
        'is_primary' => 'boolean',
        'sort_order' => 'integer'
    ];

    protected $appends = ['url'];

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string{
        return Storage::disk('public')->url($this->image_path);
    }
}
