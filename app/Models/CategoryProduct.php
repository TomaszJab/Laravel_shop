<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;
    protected $fillable = ['name_category_product'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}