<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public static function isActive()
    {
        return self::where('is_active', 1)->orderBy('created_at', 'desc');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function productgroup()
    {
        return $this->hasMany(ProductGroup::class);
    }

    public function lang()
    {
        return $this->hasOne(ProductLang::class, 'base_id', 'id')->where('lang', 'id');
    }

    public function productlang()
    {
        return $this->hasOne(ProductLang::class, 'base_id', 'id')->where('lang', 'id');
    }
}
