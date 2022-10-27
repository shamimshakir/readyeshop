<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'current_ammount',
        'allocate_ammount',
        'allocation_date',
        'total',
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
    
}
