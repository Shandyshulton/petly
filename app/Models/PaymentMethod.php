<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $primaryKey = "payment_method_id";
    public $incrementing = false;

    protected $fillable = [
        'payment_method_id',
        'payment_method_name',
    ];
}
