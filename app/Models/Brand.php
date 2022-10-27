<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_display',
        'other_band_name',
        'status',
        'user_id'
        ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function Products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
    public function statuses()
    {
        return $this->belongsTo(Status::class,'status','id');
    }
}
