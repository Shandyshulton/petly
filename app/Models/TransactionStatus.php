<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    protected $primaryKey = "transaction_status_id";

    protected $fillable = [
        'transaction_status_name',
    ];

    public function transaction() {
        return $this->hasMany(Transaction::class);
    }
}
