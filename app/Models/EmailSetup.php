<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSetup extends Model
{
    use HasFactory;

    protected $fillable = [       
                'name',
                'port',
                'Username',
                'Password',
                'setFrom',
                'SMTPAuth',
                'Host',
                'SMTPSecure',
                'addReplyTo',
                'addCC',
                'addBCC',
                'isHTML',
                'Mailer',
                'send_email',
                'receive_email',
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
