<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'category',
        'brand',
        'price',
        'qty',
        'img',
        'highlight'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function Categorys() 
    {
        return $this->belongsTo(Category::class, 'category', 'cat_name');
    }

    public function Brands()
    {
        return $this->belongsTo(Brand::class,'brand','brand_display');
    }
}
