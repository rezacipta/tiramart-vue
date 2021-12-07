<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $labels = array('newLabel', 'flashSaleLabel', 'promoLabel', 'premiumLabel');
        $images = array('20002300007.jpg', '20002700033.jpg', '10000200003.jpg', '10000300005.jpg', 'no-image.jpg');
        $before = array(100000, 200000, 300000);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'type' => $this->type,
            'price' => $this->amount,
            'priceBefore' => $this->amount + $before[array_rand($before)],
            'weight' => $this->weight,
            'title' => $this->productlang->title,
            'label' => $labels[array_rand($labels)],
            'image' => $images[array_rand($images)],
        ];
    }
}
