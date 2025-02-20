<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'personal_details_id', 'method_delivery','method_payment','promo_code','delivery','payment'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_product_id');
    }

    public function personalDetails()
    {
        return $this->belongsTo(personalDetails::class, 'personal_detail_id');
    }
}
