<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrnMatReceiveDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoiceobject_id',
        'sl_no',
        'cat_id',
        'prod_id',
        'color_id',
        'size_id',
        'prod_description',
        'rate',
        'qty',
        'unit',
        'vat',
        'total',
        'out_qty',
    ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class,'prod_id','id');
    }

    public function colors()
    {
        return $this->belongsTo(Color::class,'color_id','id');
    }
    public function sizes()
    {
        return $this->belongsTo(Size::class,'size_id','id');
    }
    public function categories()
    {
        return $this->belongsTo(Category::class,'cat_id','id');
    }
    
}
