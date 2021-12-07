<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public static function isActive()
    {
        return self::where('active', 1)->orderBy('created_at', 'desc');
    }
}
