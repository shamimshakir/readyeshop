<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'link',
        'act_status',
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
    
    public function statuses()
    {
        return $this->belongsTo(Status::class,'act_status','id');
    }
}
