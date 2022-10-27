<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'country_id',
        'price',
        'user_id'
    ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function countries() {
        return $this->belongsTo(Countrie::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
