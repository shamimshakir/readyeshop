<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adv extends Model
{
    use HasFactory;

    protected $fillable = [
        'comp_name',
        'business_type',
        'adv_position',
        'comp_url',
        'comp_status',
        'comp_image',
        'start_date',
        'end_date',
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
    
    public function Status()
    {
        return $this->belongsTo(Status::class,'comp_status','id');
    }
}
