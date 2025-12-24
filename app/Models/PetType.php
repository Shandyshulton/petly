<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetType extends Model
{
    protected $primaryKey = "pet_type_id";

    protected $fillable = [
        'pet_type_name',
    ];

    protected $hidden = [
        'pet_type_id',
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
