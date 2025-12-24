<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $table = "users";
    protected $primaryKey = "user_id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'username',
        'email',
        'password',
        'phone_number',
        'token',
        'role_role_id'
    ];

    protected $hidden = [
        // 'user_id',
        'password',
        'token',
        'created_at',
        'updated_at'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo{
        return $this->belongsTo(Role::class, 'role_role_id', 'role_id');
    }

    public function delivery(): HasMany{
        return $this->hasMany(Delivery::class);
    }

    public function customerDetails() {
        return $this->hasOne(Customer::class);
    }

    public function courierDetails() {
        return $this->hasOne(Courier::class);
    }

    public function adminDetails() {
        return $this->hasOne(Admin::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }
}
