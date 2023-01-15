<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carts extends Model
{
    use HasFactory;

    protected $table = "carts";

    protected $fillable = [
        'user_id',
        'product_id',
        'product_quantity'
    ];
}
