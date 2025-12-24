<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    protected $primaryKey = "delivery_id";

    protected $fillable = [
        'delivery_deadline',
        'delivery_address',
        'courier_id',
        'delivery_delivery_class_id'
    ];

    protected $hidden = [
        'delivery_id',
    ];

    public function deliveryClass() {
        return $this->belongsTo(DeliveryClass::class, 'delivery_delivery_class_id', 'delivery_class_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'courier_id', 'user_id');
    }

    public function courier() {
        return $this->belongsTo(Courier::class, 'courier_id', 'user_user_id');
    }

    public function transaction() {
        return $this->hasOne(Transaction::class, 'delivery_delivery_id', 'delivery_id');
    }
}
