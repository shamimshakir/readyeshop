<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaTag extends Model
{
    use HasFactory;

    protected $fillable = [       
        'meta_page',
        'meta_name',
        'meta_content',
        'meta_type',
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
