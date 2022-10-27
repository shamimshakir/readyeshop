<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'slider_name',
        'timestamp',
        'status',
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

    public function sliderimages()
    {
        return $this->hasMany(SliderImage::class,'slider_id');
    }

    public function statuses()
    {
        return $this->belongsTo(Status::class,'status','id');
    }
}
