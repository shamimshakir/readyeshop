<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = [
        'size_display',
        'size_type',
        'size_remarks',
        'status',
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

    public function statuses()
    {
        return $this->belongsTo(Status::class,'status','id');
    }
}
