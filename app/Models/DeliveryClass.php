<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryClass extends Model
{
    protected $primaryKey = "delivery_class_id";

    protected $fillable = [
        'delivery_class_price',
        'delivery_class_name',
        'delivery_class_desc',
    ];

    public function delivery(): HasMany{
        return $this->hasMany(Delivery::class);
    }
}
