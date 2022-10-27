<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetup extends Model
{
    use HasFactory;

     protected $fillable = [
        'company_name',
        'website_slogan',
        'website_url',
        'comp_address',
        'business_type_id',
        'favicon',
        'logo',
        'contact_email',
        'contact_phone',
        'contact_map_location',
        'district',
        'thana',
        'currency',
        'theme',
        'brand_filtering',
        'color_filtering',
        'price_filtering',
        'user_id',
        'themecolor'
        ];

    /**
     * Belongs To Relation - Eloquent Relation For Todo user
     *
     * @return void
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function currencys()
    {
        return $this->belongsTo(Currency::class,'currency','id');
    }
    public function themes()
    {
        return $this->belongsTo(Theme::class,'theme','id');
    }
}
