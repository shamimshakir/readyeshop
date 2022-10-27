<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'pd_id',
        'ct_qty',
        'ct_session_id',
        'cl_id',
        'size_id',
        'color_id',
        'price'
        ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function customers()
    {
        return $this->belongsTo(Customer::class,'cl_id','id');
    }
    public function colors()
    {
        return $this->belongsTo(Color::class,'color_id','id');
    }
    public function sizes()
    {
        return $this->belongsTo(Size::class,'size_id','id');
    }
    public function products()
    {
        return $this->belongsTo(Product::class,'pd_id','id');
    }
}
