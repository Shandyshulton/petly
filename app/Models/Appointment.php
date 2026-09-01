<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $primaryKey = 'appointment_id';

    protected $fillable = [
        'user_user_id',
        'service_type',
        'appointment_date',
        'appointment_time',
        'pet_name',
        'pet_species',
        'pet_breed',
        'notes',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_user_id', 'user_id');
    }
}
