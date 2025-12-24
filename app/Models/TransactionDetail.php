<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $primaryKey = "transaction_transaction_id";

    protected $fillable = [
        'transaction_transaction_id',
        'total_payment',
        'foreign_product_id',
        'quantity'
    ];

    protected $hidden = [
        'transaction_transaction_id',
    ];

    public function transaction() {
        return $this->hasOne(Transaction::class, 'transaction_transaction_id', 'transaction_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'foreign_product_id', 'product_id');
    }
}
