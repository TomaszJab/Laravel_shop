<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'detail' => $this->detail,
            'favorite' => $this->favorite,
            'category_products_id' => $this->category_products_id,
            'created_at' => $this->created_at,//?->toDateTimeString(),
            'updated_at' => $this->updated_at//?->toDateTimeString(),
        ];
    }
}
