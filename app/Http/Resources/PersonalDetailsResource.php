<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalDetailsResource extends JsonResource
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
            'user_id' => $this->user_id,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'company_or_private_person' => $this->company_or_private_person,
            'nip' => $this->nip,
            'street' => $this->street,
            'house_number' => $this->house_number,
            'zip_code' => $this->zip_code,
            'city' => $this->city,
            'additional_information' => $this->additional_information,
            'acceptance_of_the_regulations' => $this->acceptance_of_the_regulations,
            'acceptance_of_the_invoice' => $this->acceptance_of_the_invoice,
            'default_personal_details' => $this->default_personal_details,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
