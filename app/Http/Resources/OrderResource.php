<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'product_id' => $this->product_id,
            'order_product_id' => $this->order_product_id,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'size' => $this->size,
            'category_products_id' => $this->category_products_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
