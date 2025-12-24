<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $primaryKey = "product_type_id";

    protected $fillable = [
        'product_type_name',
    ];

    protected $hidden = [
        'product_type_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
