<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public static function get($module, $key)
    {
        return self::where('module', $module)->where('key', $key)->first()->val;
    }
}
