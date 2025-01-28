<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'scientific_name',
        'Trade_name',
        'category_id',
        'Company_name' ,
        'Quantity_products',
        'Expiation_date',
        'Price',
        'Image'
    ];





    public function Order_products(){
         return $this->hasMany('Order_product');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
