<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsSetup extends Model
{
    use HasFactory;

    protected $fillable = [       
        'name',
        'sms_url',
        'submit_param',
        'return_param',
        'return_value_type',
        'type',
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
