<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'view',
        'add',
        'edit',
        'delete',
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
    public function userProfile() {
        return $this->belongsTo(User::class,'profile_id');
    }
    public function treeMenu() {
        return $this->belongsTo(TreeEntry::class,'id','view');
    }
}
