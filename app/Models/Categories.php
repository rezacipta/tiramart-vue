<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public static function isActive()
    {
        return self::where('is_active', 1);
    }

    public function lang()
    {
        return $this->hasOne(CategoriesLang::class, 'base_id', 'id')->where('lang', 'id');
    }
}
