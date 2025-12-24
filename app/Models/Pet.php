<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $primaryKey = "pet_id";

    protected $fillable = [
        'pet_name',
        'pet_gender',
        'pet_weight',
        'pet_pet_types_id',
        'user_user_id',
    ];

    protected $hidden = [
        'pet_id',
        'password',
        'token',
        'role_role_id',
        'created_at',
        'updated_at'
    ];

    public function customerDetails()
    {
        return $this->belongsTo(User::class, 'user_user_id', 'user_id');
    }

    public function petTypeDetails()
    {
        return $this->belongsTo(PetType::class, 'pet_pet_types_id', 'pet_type_id');
    }
}
