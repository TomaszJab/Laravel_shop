<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'firstName',
        'lastName',
        'phone',
        'company_name',
        'company_or_private_person',
        'nip',
        'street',
        'house_number',
        'zip_code',
        'city',
        'additional_information',
        'acceptance_of_the_regulations',
        'acceptance_of_the_invoice',
        'default_personal_details'
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'personal_detail_id');
    }
}
