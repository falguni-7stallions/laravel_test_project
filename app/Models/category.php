<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'status'];
    const ACTIVE = 1;
    const INACTIVE = 0;

    public static function getStatus($status = null)
    {
        $array = [
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        ];
        if(!is_null($status) && $status>=0){
            return $array[$status];
        }
        return $array;
    }
}
