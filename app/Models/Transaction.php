<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = "transaction_id";

    protected $fillable = [
        'transaction_date',
        'user_user_id',
        'delivery_delivery_id',
        'foreign_cart_id',
        'transactions_transaction_status_id',
    ];

    public function transactionDetails() {
        return $this->hasOne(TransactionDetail::class);
    }

    public function cart() {
        return $this->belongsTo(Cart::class, 'foreign_cart_id' ,'cart_id');
    }

    public function delivery() {
        return $this->belongsTo(Delivery::class, 'delivery_delivery_id', 'delivery_id')->withDefault();
    }

    public function transactionStatus() {
        return $this->belongsTo(TransactionStatus::class, 'transactions_transaction_status_id', 'transaction_status_id');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user_user_id', 'user_id');
    }
}
