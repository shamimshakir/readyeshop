<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'trans_id',
        'trans_date',
        'result',
        'result_code',
        'prn',
        'card_number',
        'amount',
        'trans_desc',
        'transdate',
        'card_name',
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
}
