<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPageInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_address',
        'contact_phone',
        'contact_email',
        'contact_map_location',
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
