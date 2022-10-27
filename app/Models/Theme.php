<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [       
        'theme_name',
        'status',
        'edit_status',
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

    public function companysetup() {
        return $this->belongsTo(CompanySetup::class);
    }

    public function statuses()
    {
        return $this->belongsTo(Status::class,'status','id');
    }
}
