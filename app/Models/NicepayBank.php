<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NicepayBank extends Model
{
    public function templates()
    {
        return $this->hasMany(NicepayBankTemplate::class);
    }
}
