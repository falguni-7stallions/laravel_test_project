<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    public function product() {
        return $this->belongsTo(product::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
