<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Appointment Slot Capacity
    |--------------------------------------------------------------------------
    |
    | Maximum number of bookings allowed per (service, date, time) slot.
    |
    */

    'capacity' => (int) env('APPOINTMENT_SLOT_CAPACITY', 5),

];
