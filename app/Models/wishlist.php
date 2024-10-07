<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlists';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'product_id'];

    public function product() {
        return $this->belongsTo(product::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
