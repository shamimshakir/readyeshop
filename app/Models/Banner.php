<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'comp_url',
        'comp_name',
        'start_date',
        'end_date',
        'user_id',
        'image',
        'active_status'
        ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function Status()
    {
        return $this->belongsTo(Status::class,'active_status','id');
    }
}
