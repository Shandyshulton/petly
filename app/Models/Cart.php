<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $primaryKey = "cart_id";

    protected $fillable = [
        'customer_user_id',
        'cart_quantity',
        'foreign_product_id',
        'quantity',
        'total_price',
    ];

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'foreign_product_id',
            'product_id'
        );
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'foreign_cart_id', 'cart_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'customer_user_id', 'user_id');
    }
}
