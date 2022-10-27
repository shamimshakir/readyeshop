<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'od_id',
        'status',
        'comments',
        'update_by',
        'update_date',
        'shiper_id',
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
    public function order() {
        return $this->belongsTo(Order::class,'od_id','id');
    }
    public function orderhistorystatus()
    {
        return $this->belongsTo(OrderStatus::class,'status','id');
    }
}
