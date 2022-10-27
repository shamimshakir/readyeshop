<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlinePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cus_id',
        'cus_name',
        'status',
        'tran_date',
        'tran_id',
        'val_id',
        'amount',
        'store_amount',
        'card_type',
        'card_no',
        'currency',
        'bank_tran_id',
        'card_issuer',
        'card_brand',
        'card_issuer_country',
        'currency_type',
        'currency_amount',
        'value_a',
        'value_b',
        'value_c',
        'value_d',
        'varify_sign',
        'verify_key',
        'risk_level',
        'risk_title',
        ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class,'cus_id','id');
    }

}
