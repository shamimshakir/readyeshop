<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'pd_id',
        'session_id',
        'customer_id',
        ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class,'pd_id','id');
    }
}
