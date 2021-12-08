<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'recipientName' => $this->recipient_name,
            'recipientPhone' => $this->phone,
            'fullAddress' => $this->address,
            'province' => $this->province_id,
            'city' => $this->city_id,
            'subdistrict' => $this->subdistrict_id,
            'detail' => $this->detail,
            'isMain' => $this->is_main ? true : false,
            'customerId' => $this->customerId,
        ];
    }
}
