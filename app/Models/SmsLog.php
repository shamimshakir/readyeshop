<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

     protected $fillable = [       
        'number',
        'sms_body',
        'return_message',
        'sms_setup_id',
        'sms_status',
        'date_time',
        'user_id',
        ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function smssetup()
    {
        return $this->belongsTo(SmsSetup::class,'sms_setup_id','id');
    }
}
