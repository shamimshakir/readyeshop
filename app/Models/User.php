<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'email',
        'phone',
        'password',
        'user_profile_id',
        'comp_address',
        'address',
        'user_guide_show',
        'company_name',
        'status',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Has Many Relation - Eloquent Relation for Todos
     *
     * @return void
     */



    public function todos() {
        return $this->hasMany(Todo::class);
    }
    
    public function UserProfile() {
        return $this->belongsTo(UserProfile::class,'user_profile_id','id');
    }
    public function UserStatus() {
        return $this->belongsTo(Status::class,'status','id');
    }

    public function countries() {
        return $this->hasMany(Countrie::class);
    }
    public function districts() {
        return $this->hasMany(District::class);
    }
    public function thanas() {
        return $this->hasMany(Thana::class);
    }
    public function customers() {
        return $this->hasMany(Customer::class);
    }
    public function statuses() {
        return $this->hasMany(Status::class);
    }
    public function colors() {
        return $this->hasMany(Color::class);
    }

    public function sizes() {
        return $this->hasMany(Size::class);
    }

    public function brands() {
        return $this->hasMany(Brand::class);
    }
    
    public function about_us() {
        return $this->hasMany(AboutUs::class);
    }
    public function social_links() {
        return $this->hasMany(SocialLink::class);
    }

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function icontype() {
        return $this->hasMany(IconType::class);
    }

    public function advs() {
        return $this->hasMany(Adv::class);
    }

    public function banners() {
        return $this->hasMany(Banner::class);
    }

    public function product() {
        return $this->hasMany(Product::class);
    }

    public function productcolor() {
        return $this->hasMany(ProductColor::class);
    }

    public function productsize() {
        return $this->hasMany(ProductSize::class);
    }
    
    public function productimage() {
        return $this->hasMany(ProductImage::class);
    }

    public function units() {
        return $this->hasMany(Unit::class);
    }
    public function faqs() {
        return $this->hasMany(Faq::class);
    }
    public function vendors() {
        return $this->hasMany(Vendor::class);
    }

    public function shippers() {
        return $this->hasMany(Shipper::class);
    }

    public function smssetups() {
        return $this->hasMany(SmsSetup::class);
    }
    public function smstemplates() {
        return $this->hasMany(SmsTemplate::class);
    }
    public function emailsetups() {
        return $this->hasMany(EmailSetup::class);
    }

    public function orderstatus() {
        return $this->hasMany(OrderStatus::class);
    }
    public function companysetups() {
        return $this->hasMany(CompanySetup::class);
    }
    public function orders() {
        return $this->hasMany(Order::class);
    }
    public function themes() {
        return $this->hasMany(Theme::class);
    }

    public function currencies() {
        return $this->hasMany(Currency::class);
    }
    public function businesstypes() {
        return $this->hasMany(BusinessType::class);
    }
    public function sliderimages() {
        return $this->hasMany(SliderImage::class);
    }
    public function sliders() {
        return $this->hasMany(Slider::class);
    }
    public function sliderbackgrounds() {
        return $this->hasMany(SliderBackground::class);
    }
    public function sponsorad() {
        return $this->hasMany(SponsorAd::class);
    }
    public function tags() {
        return $this->hasMany(Tag::class);
    }
    public function parameters() {
        return $this->hasMany(Parameter::class);
    }
    public function homepageconfigs() {
        return $this->hasMany(HomePageConfig::class);
    }
    public function footers() {
        return $this->hasMany(Footer::class);
    }
    public function paymentstatuses() {
        return $this->hasMany(PaymentStatus::class);
    }
    public function paymentmethods() {
        return $this->hasMany(PaymentMethod::class);
    }
    public function paymenticons() {
        return $this->hasMany(PaymentIcon::class);
    }
    public function treeentrys() {
        return $this->hasMany(TreeEntry::class);
    }
    public function MasMatReceive() {
        return $this->hasMany(MasMatReceive::class);
    }
    public function ProductTag() {
        return $this->hasMany(ProductTag::class);
    }
    public function Promotion() {
        return $this->hasMany(Promotion::class);
    }
    public function ProductFilter() {
        return $this->hasMany(ProductFilter::class);
    }

    public function status_d()
    {
        return $this->belongsTo(Status::class,'status','id');
    }
}
