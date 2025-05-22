<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            'personal_details_id' => $this->personal_details_id,
            'method_delivery' => $this->method_delivery,
            'method_payment' => $this->method_payment,
            'promo_code' => $this->promo_code,
            'delivery' => $this->delivery,
            'payment' => $this->payment,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
