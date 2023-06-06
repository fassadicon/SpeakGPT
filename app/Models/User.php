<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

}
