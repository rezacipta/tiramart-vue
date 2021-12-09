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
            'provinceId' => $this->province_id,
            'province' => $this->province->name,
            'cityId' => $this->city_id,
            'city' => $this->city->name,
            'subdistrictId' => $this->subdistrict_id,
            'subdistrict' => $this->subdistrict->name,
            'postalcode' => $this->subdistrict->postal_code,
            'detail' => $this->detail,
            'isMain' => $this->is_main ? true : false,
            'customerId' => $this->customerId,
        ];
    }
}
