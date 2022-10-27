<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrnProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'pd_id',
        'color_id',
        'size_id',
        'qty',
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
        return $this->belongsTo(Product::class,'pd_id','id');
    }

    public function colors()
    {
        return $this->belongsTo(Color::class,'color_id','id');
    }
    public function sizes()
    {
        return $this->belongsTo(Size::class,'size_id','id');
    }

}
