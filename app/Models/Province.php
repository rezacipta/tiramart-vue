<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    // protected $with = ['cities.subdistricts'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
