<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterOption extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'filter_id',
        'option_name',
        'others_option_name',
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
    public function productfilter() {
        return $this->belongsTo(ProductFilter::class,'filter_id','id');
    }
    
}
