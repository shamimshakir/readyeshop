<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'mobile',
        'email',
        'name',
        'domain',
        'address',
        'logo',
        'status',
        'sub_domain',
        'server_status',
        'domain_type',
        'cstatus',
        'exp_date'
        ];
}
