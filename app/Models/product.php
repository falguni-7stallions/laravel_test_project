<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
//    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'image', 'description', 'price', 'category_id'];

    public function cartItems() {
        return $this->hasMany(cart::class);
    }
    public function favorites() {
        return $this->hasMany(wishlist::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($product) {  //delete all product_id related to product id and then product deleted
            $product->cartItems()->delete();
            $product->favorites()->delete();
        });
    }
}
