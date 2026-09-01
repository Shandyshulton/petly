<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $table = "couriers";
    protected $primaryKey = "user_user_id";
    public $incrementing = false;

    protected $fillable = [
        'user_user_id',
        'status',
        'vehicle_name',
        'plate_number'
    ];

    protected $hidden = [
        'user_user_id',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_user_id', 'user_id');
    }

    public function delivery(){
        return $this->hasMany(Delivery::class, 'courier_id', 'user_user_id');
    }
}
