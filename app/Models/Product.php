<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','price', 'detail','category_products_id'];

    public function comments()
    {
     return $this->hasMany(Comment::class);
    }

    public function categoryProducts()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_products_id');
    }
    //product_id
    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id');
    }
}
