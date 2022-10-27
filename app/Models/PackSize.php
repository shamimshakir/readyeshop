<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'packweight',
        'packheight',
        'packwidth',
        'packlength',
        'cubicsize',
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
