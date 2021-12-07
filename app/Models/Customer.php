<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $guarded = ['id'];
    protected $hidden = ['remember_token'];
}
