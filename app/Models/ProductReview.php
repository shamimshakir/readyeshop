<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cust_id',
        'review',
        'rating',
        'pd_id',
        ];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'cust_id','id');
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
