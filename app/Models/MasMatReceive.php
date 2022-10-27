<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasMatReceive extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'client_id',
        'remarks',
        'vat',
        'vatper',
        'bill_amount',
        'total_bill',
        'discount_amnt',
        'comments',
        'view_status',
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

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'client_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class,'view_status','id');
    }
    public function trnMatReceives() 
    {
        //return $this->hasMany(TrnMatReceiveDetail::class,'invoiceobject_id')->categories()->products()->colors()->sizes();
        return $this->hasMany(TrnMatReceiveDetail::class,'invoiceobject_id')->with('categories')->with('products')->with('colors')->with('sizes');
    }
}
