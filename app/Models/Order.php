<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'od_no',
        'cl_id',
        'od_date',
        'od_last_update',
        'od_status',
        'status_change_comment',
        'od_memo',
        'od_shipping_first_name',
        'od_shipping_last_name',
        'od_shipping_address1',
        'od_shipping_address2',
        'od_shipping_email',
        'od_shipping_phone',
        'od_shipping_city',
        'od_shipping_thana',
        'od_shipping_state',
        'od_shipping_postal_code',
        'od_shipping_cost',
        'od_shipping_country',
        'od_shipping_fax',
        'od_shipping_company',
        'od_payment_first_name',
        'od_payment_last_name',
        'od_payment_address1',
        'od_payment_address2',
        'od_payment_phone',
        'od_payment_email',
        'od_payment_city',
        'od_payment_state',
        'od_payment_postal_code',
        'od_payment_country',
        'od_payment_fax',
        'od_payment_company',
        'reward_point_use',
        'product_cost',
        'hst',
        'total_cost',
        'reward_point_gain',
        'reward_point_gain_leastime',
        'ship_date',
        'paid_date',
        'loc_id',
        'update_by',
        'update_date',
        'order_deliverymode',
        'order_payment_method',
        'order_paymobile',
        'order_pay_ref_no',
        'orde_mobile_pay_method',
        'od_payment_amount',
        'od_payment_date',
        'od_payment_update_by',
        'od_verify_address',
        'od_verify_by',
        'od_veryfy_date',
        'od_receive_date',
        'od_delivary_date',
        'payment_status',
        'pay_remark',
        'shipper_id',
        'shipper_collect',
        'shipper_collect_date',
        'shipper_remark',
        'traking_id',
        'user_id',
        'od_payment_thana',
        'status',
        'transaction_id',
        'currency'
        ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orderstatus()
    {
        return $this->belongsTo(OrderStatus::class,'od_status','id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class,'cl_id','id');
    }

    public function thana()
    {
        return $this->belongsTo(Thana::class,'od_shipping_thana','id');
    }

    public function countrys()
    {
        return $this->belongsTo(Countrie::class,'od_shipping_country','id');
    }

    public function citys()
    {
        return $this->belongsTo(District::class,'od_shipping_city','id');
    }

    public function orderitems() 
    {
        return $this->hasMany(OrderItem::class,'od_id')->with('product')->with('size')->with('color');
    }
    public function orderhistorys() 
    {
        return $this->hasMany(OrderHistory::class,'od_id')->with('orderhistorystatus');
    }

    public function latestStatus(){
        return $this->hasOne(OrderHistory::class,'od_id')->latest('id');
    } 
}
