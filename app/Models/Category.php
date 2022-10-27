<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_parent_id',
        'cat_name',
        'cat_description',
        'cat_name_others',
        'cat_description_others',
        'meta_keyword',
        'meta_description',
        'cat_image',
        'level_id',
        'act_status',
        'catagory_code',
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

    public function Products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }


    public function categories()
    {
        return $this->hasMany(self::class, 'cat_parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(self::class,'cat_parent_id', 'id')->with('childrenCategories');
    }

   
    public function childrenCategories_id()
    {
        return $this->hasMany(self::class,'cat_parent_id', 'id')->with('childrenCategories_id')->select('id','cat_parent_id');
    }
/*
    public function children()
    {
        return $this->hasMany(self::class, 'cat_parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(self::class, 'cat_parent_id');

    }
   
 */   
}
