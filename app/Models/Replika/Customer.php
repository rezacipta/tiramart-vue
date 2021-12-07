<?php

namespace App\Models\Replika;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $connection = 'replika';
    protected $hidden = ['id', 'remember_token'];
    protected $casts = [
        // 'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
