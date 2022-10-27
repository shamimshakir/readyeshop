<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductActiveTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'tagid',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function productTag() {
        return $this->belongsTo(ProductTag::class,'tagid');
    }
}
