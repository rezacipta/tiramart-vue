<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NicepayBankTemplate extends Model
{
    public function bank()
    {
        return $this->belongsTo(NicepayBank::class);
    }
}
