<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'pid',
        'NodeName',
        'others_lan',
        'file_name',
        'file_location',
        'icon',
        'view_status',
        'sl',
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

    public function statuses()
    {
        return $this->belongsTo(Status::class,'view_status','id');
    }
    public function menus()
    {
        return $this->hasMany(TreeEntry::class,'pid','id');
    }
    public function permission()
    {
        return $this->hasMany(ProfilePermission::class,'view','id');
    }
    public function children(){
        return $this->hasMany(TreeEntry::class, 'pid','id')->with('menus');
    }


}
