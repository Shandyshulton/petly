<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = "payment_id";

    protected $fillable = [
        'payment_payment_method_id',
        'payment_transaction_id',
    ];
}
