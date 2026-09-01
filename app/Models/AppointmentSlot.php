<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentSlot extends Model
{
    protected $primaryKey = 'slot_id';

    protected $fillable = [
        'service_type',
        'appointment_date',
        'appointment_time',
        'capacity',
        'booked_count',
    ];
}
