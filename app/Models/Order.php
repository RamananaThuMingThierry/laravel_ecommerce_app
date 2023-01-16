<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        'firstname',
        'user_id',
        'lastname',
        'phone',
        'email',
        'address',
        'city',
        'zipcode',
        'state',
        'payment_id',
        'payment_mode',
        'tracking_no',
        'status',
        'remark'
    ];

    public function orderitems(){
        return $this->hasMany(OrdersItem::class, 'order_id', 'id');
    }

    
}
