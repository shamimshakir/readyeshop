<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'email_body',
        'return_message',
        'email_setup_id',
        'snder_id',
        'email_status',
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

    public function emailsetup()
    {
        return $this->belongsTo(EmailSetup::class,'email_setup_id','id');
    }
}
