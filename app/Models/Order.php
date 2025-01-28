<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'Order_status',
        'Payment_status'
    ];





    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function Order_products(){
        return $this->hasMany('Order_product');
    }
}
