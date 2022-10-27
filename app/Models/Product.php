<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'pd_code',
        'category_id',
        'brand_id',
        'unit_type',
        'pd_name',
        'pd_description',
        'pd_price',
        'pd_prev_price',
        'pd_price_comments',
        'pd_qty',
        'pd_image',
        'pd_image_alt',
        'pd_thumbnail',
        'product_detail',
        'product_specification',
        'product_warranty',
        'pd_date',
        'pd_last_update',
        'reward_point',
        'prod_type',
        'prod_stat_type',
        'feature_stat',
        'popular_stat',
        'other_stat',
        'new_stat',
        'hst',
        'upsstat',
        'packweight',
        'packheight',
        'packwidth',
        'packlength',
        'pd_m_thumbnail',
        'onsale_stat',
        'timestamp',
        'pd_status',
        'color_apply',
        'size_apply',
        'detail_status',
        'specification_status',
        'warranties_status',
        'product_highlight',
        'meta_keyword',
        'meta_description',
        'user_id',
        'video'
    ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
    

    public function Category() 
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function Brand()
    {
        return $this->belongsTo(Brand::class,'brand_id','id');
    }

    public function Unit()
    {
        return $this->belongsTo(Unit::class,'unit_type','id');
    }

    public function Status()
    {
        return $this->belongsTo(Status::class,'pd_status','id');
    }

    public function productcolors() 
    {
        return $this->hasMany(ProductColor::class)->with('color');
    }
    public function productsizes() 
    {
        return $this->hasMany(ProductSize::class)->with('size');
    }

    public function productactivetags() 
    {
        return $this->hasMany(ProductActiveTag::class)->with('productTag');
    }
    public function productreview() 
    {
        return $this->hasMany(productreview::class);
    }

    public function productimages() 
    {
        return $this->hasMany(ProductImage::class);
    }


    public function reviewRows()
    {
        return $this->hasMany(ProductReview::class,'pd_id');
    }

    public function avgRating()
    {
        return $this->reviewRows()
          ->selectRaw('avg(rating) as aggregate, pd_id')
          ->groupBy('pd_id');
    }

    public function getAvgRatingAttribute()
    {
        if ( ! array_key_exists('avgRating', $this->relations)) {
           $this->load('avgRating');
        }
        $relation = $this->getRelation('avgRating')->first();
        return ($relation) ? $relation->aggregate : null;
    }
}
