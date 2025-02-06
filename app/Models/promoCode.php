<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class promoCode extends Model
{
    use HasFactory;
    protected $fillable = ['promo_code','valid_from', 'valid_until'];
}
