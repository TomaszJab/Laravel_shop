<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personalDetails extends Model
{
    use HasFactory;
    protected $fillable = ['email','firstName','lastName','phone','company_name','company_or_private_person','nip','street','house_number','zip_code','city','additional_information','acceptance_of_the_regulations','acceptance_of_the_invoice'];
}
