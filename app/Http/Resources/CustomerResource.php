<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'phone' => $this->whatsapp_number,
            'email' => $this->email,
        ];
    }
}
