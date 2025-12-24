<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = "admins";
    protected $primaryKey = "user_user_id";
    public $incrementing = false;

    protected $fillable = [
        'user_user_id',
        'phone_number'
    ];

    protected $hidden = [
        'user_user_id',
        'token',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
