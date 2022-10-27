<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'stat_desc',
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
    public function unit() {
        return $this->hasMany(Unit::class);
    }
    public function adv() {
        return $this->hasMany(Adv::class);
    }

    public function banner() {
        return $this->hasMany(Banner::class);
    }

    public function faq() {
        return $this->hasMany(Faq::class);
    }

    public function vendor() {
        return $this->hasMany(Vendor::class);
    }

    public function shipper() {
        return $this->hasMany(Shipper::class);
    }
    
    public function Products()
    {
        return $this->hasMany(Product::class, 'pd_status');
    }

    public function smssetup() {
        return $this->hasMany(SmsSetup::class);
    }

    public function smstemplate() {
        return $this->hasMany(SmsTemplate::class);
    }

    public function emailsetup() {
        return $this->hasMany(EmailSetup::class);
    }

    public function themes() {
        return $this->hasMany(Theme::class,"status");
    }

    public function currencies() {
        return $this->hasMany(Currency::class,"status");
    }
}
