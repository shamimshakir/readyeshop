<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
         'od_id',
         'pd_id',
         'od_qty',
         'pd_price',
         'hst',
         'reward_point_avail',
         'reward_point_leastime',
         'upscharge',
         'pick_loc_id',
         'rec_amnt',
         'rec_remarks',
         'rec_date',
         'rec_by',
         'rec_status',
         'return_qty',
         'return_amnt',
         'return_point',
         'return_reward_point_leastime',
         'return_date',
         'size_id',
         'color_id',
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

    public function product() {
        return $this->belongsTo(Product::class,'pd_id','id');
    }
    public function size() {
        return $this->belongsTo(Size::class,'size_id','id');
    }
    public function color() {
        return $this->belongsTo(Color::class,'color_id','id');
    }

    public function order() {
        return $this->belongsTo(Order::class,'od_id','id');
    }

}
