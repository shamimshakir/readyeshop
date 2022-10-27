<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'ord_status',
        'sl',
        'icon',
        'user_id',
        'status'
        ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function statues()
    {
        return $this->belongsTo(Status::class,'status','id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'od_status');
    }
}
