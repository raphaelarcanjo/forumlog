<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPassword;

class User extends Authenticatable implements CanResetPassword
{
    use Notifiable;
    protected $table = 'users';
}
