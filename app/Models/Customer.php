<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'customer';

    protected $fillable = [
    'cl_pin',
    'cl_code',
    'surname',
    'firstname',
    'lastname',
    'address',
    'address1',
    'street',
    'city',
    'postal_code',
    'province',
    'country',
    'company',
    'phone',
    'fax',
    'email',
    'user_regdate',
    'user_last_login',
    'reward_point',
    'customer_type',
    'user_stat',
    'varified_status',
    'varified_by',
    'varified_date',
    'district',
    'varify_code',
    'google_code',
    'facebook_id',
    'thana',
    'password',
    'avatar',
    'provider_id',
    'provider',
    'access_token'
    ];
   

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];    


    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
   public function countries() {
       return $this->belongsTo(Countrie::class,'country','id');
   }

   public function districts() {
       return $this->belongsTo(District::class,'district','id');
   }

   public function thanas() {
       return $this->belongsTo(Thana::class,'thana','id');
   }  
    
    public function users() {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'cl_id');
    }
}
