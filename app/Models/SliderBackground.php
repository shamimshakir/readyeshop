<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'active_status',
        'main_text',
        'second_text',
        'additional_text',
        'bg_type',
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
        return $this->belongsTo(Status::class,'active_status','id');
    }
}
