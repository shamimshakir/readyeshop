<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_user',
        'vendor_pass',
        'vendor_name',
        'company_name',
        'address',
        'street',
        'city',
        'postal_code',
        'province',
        'country',
        'phone',
        'email',
        'user_regdate',
        'user_last_login',
        'reward_point_percent',
        'reward_point_percent_customer',
        'pick_loc_id',
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
    
    public function statuses()
    {
        return $this->belongsTo(Status::class,'status','id');
    }
}
