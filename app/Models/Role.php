<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $primaryKey = "role_id";

    protected $fillable = [
        'role_name',
    ];

    protected $hidden = [
        // 'role_id',
        'created_at',
        'updated_at'
    ];

    public function user(): HasMany{
        return $this->hasMany(User::class, 'role_role_id', 'role_id');
    }
}
