<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPassword;

class User extends Authenticatable implements CanResetPassword
{
    use Notifiable;
    use HasFactory;

    public function blog()
    {
        return $this->hasMany(Blog::class);
    }

    public function phone()
    {
        return $this->hasMany(Phone::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
