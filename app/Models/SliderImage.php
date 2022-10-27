<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'slider_id',
        'bg_img',
        'url',
        'main_text',
        'title_text',
        'alt_text',
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

    public function sliders()
    {
        return $this->hasMany(Slider::class,'id','slider_id');
    }

    public function statuses()
    {
        return $this->belongsTo(Status::class,'act_status','id');
    }

}
