<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name',
        'district_id',
        'coverage',
        'drop_point'
    ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function districts() {
        return $this->belongsTo(District::class);
    }
    
    public function users() {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'od_shipping_thana');
    }
}

