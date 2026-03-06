<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];
    protected $casts = [
        'cart_id' => 'integer',
        'product_id' => 'integer',
        'quantity' => 'integer', // quantity selalu int, bukan string
    ];

    public function cart(){
        return $this->belongsTo(Cart::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    // access mutator
    
    public function getSubtotalAttribute(){
        return $this->product->price * $this->quantity;
    } 

}
    