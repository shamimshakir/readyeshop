<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\api\UserController;
use App\Http\Controllers\admin\api\TodoController;
use App\Http\Controllers\admin\api\CountrieController;
use App\Http\Controllers\admin\api\DistrictController;
use App\Http\Controllers\admin\api\ThanaController;
use App\Http\Controllers\admin\api\CustomerController;
use App\Http\Controllers\admin\api\StatusController;
use App\Http\Controllers\admin\api\ColorController;
use App\Http\Controllers\admin\api\SizeController;
use App\Http\Controllers\admin\api\BrandController;
use App\Http\Controllers\admin\api\AboutUsController;
use App\Http\Controllers\admin\api\SocialLinkController;
use App\Http\Controllers\admin\api\CategoryController;
use App\Http\Controllers\admin\api\IconTypeController;
use App\Http\Controllers\admin\api\IconController;
use App\Http\Controllers\admin\api\UnitController;
use App\Http\Controllers\admin\api\ProductController;
use App\Http\Controllers\admin\api\BannerController;
use App\Http\Controllers\admin\api\AdvController;
use App\Http\Controllers\admin\api\FaqController;
use App\Http\Controllers\admin\api\VendorController;
use App\Http\Controllers\admin\api\ShipperController;
use App\Http\Controllers\admin\api\LanguageController;
use App\Http\Controllers\admin\api\SmsSetupController;
use App\Http\Controllers\admin\api\SmsTemplateController;
use App\Http\Controllers\admin\api\SmsLogController;
use App\Http\Controllers\admin\api\EmailSetupController;
use App\Http\Controllers\admin\api\OrderStatusController;
use App\Http\Controllers\admin\api\OrderController;
use App\Http\Controllers\admin\api\CompanySetupController;
use App\Http\Controllers\admin\api\ThemeController;
use App\Http\Controllers\admin\api\CurrencyController;
use App\Http\Controllers\admin\api\BusinessTypeController;
use App\Http\Controllers\admin\api\SliderController;
use App\Http\Controllers\admin\api\SliderImageController;
use App\Http\Controllers\admin\api\SliderBackgroundController;
use App\Http\Controllers\admin\api\TagController;
use App\Http\Controllers\admin\api\EmailTemplateController;
use App\Http\Controllers\admin\api\EmailLogController;
use App\Http\Controllers\admin\api\ParameterController;
use App\Http\Controllers\admin\api\HomePageConfigController;
use App\Http\Controllers\admin\api\FooterController;
use App\Http\Controllers\admin\api\PaymentStatusController;
use App\Http\Controllers\admin\api\PaymentMethodController;
use App\Http\Controllers\admin\api\PaymentIconController;
use App\Http\Controllers\admin\api\EmailTestController;
use App\Http\Controllers\admin\api\SmsTestController;
use App\Http\Controllers\admin\api\MetaTagController;
use App\Http\Controllers\admin\api\PagesContentController;
use App\Http\Controllers\admin\api\SponsorAdController;
use App\Http\Controllers\admin\api\MasMatReceiveController;
use App\Http\Controllers\admin\api\ThirdpartyAuthController;
use App\Http\Controllers\admin\api\SmsAllocationController;
use App\Http\Controllers\admin\api\OnlinePaymentController;
use App\Http\Controllers\admin\api\ReportController;
use App\Http\Controllers\admin\api\UserProfileController;
use App\Http\Controllers\admin\api\UserGuideController;
use App\Http\Controllers\admin\api\ContactPageInfoController;
use App\Http\Controllers\admin\api\CssController;
use App\Http\Controllers\admin\api\LevelController;
use App\Http\Controllers\admin\api\NewsController;
use App\Http\Controllers\admin\api\PaymentOptionController;
use App\Http\Controllers\admin\api\PackSizeController;
use App\Http\Controllers\admin\api\CustomerTypeController;
use App\Http\Controllers\admin\api\PickupLocationController;
use App\Http\Controllers\admin\api\ResultCodeController;
use App\Http\Controllers\admin\api\FbMassengerController;
use App\Http\Controllers\admin\api\TransLogController;
use App\Http\Controllers\admin\api\TreeEntryController;
use App\Http\Controllers\admin\api\ProductTagController;
use App\Http\Controllers\admin\api\CartController;
use App\Http\Controllers\admin\api\WishlistController;
use App\Http\Controllers\admin\api\CompareController;
use App\Http\Controllers\OutController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\admin\api\SubscribeController;
use App\Http\Controllers\admin\api\ContactController;
use App\Http\Controllers\admin\api\ProductReviewController;
use App\Http\Controllers\admin\api\PromotionController;
use App\Http\Controllers\admin\api\DashboardController;
use App\Http\Controllers\admin\api\ProfilePermissionController;
use App\Http\Controllers\admin\api\ProductImportController;
use App\Http\Controllers\admin\api\ProductFilterController;
//fondend start
use App\Http\Controllers\HomeConfigController;
use App\Http\Controllers\ParameterConfigController;


use App\Http\Controllers\ShopUserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('shop_user', [ShopUserController::class, 'index']);

Route::prefix('user')->group(function () {

    Route::post('user_register', [UserController::class, 'register']);
    
    Route::post('login', [UserController::class, 'login']);
    
    Route::post('login_sso', [UserController::class, 'login_sso']);

    // passport auth api
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/', [UserController::class, 'user']);
        Route::get('logout', [UserController::class, 'logout']);


        Route::resource('users', UserController::class);

        Route::post('change_password', [UserController::class, 'change_password']);
        // todos resource route
        Route::resource('todos', TodoController::class);

        // countries resource route
        Route::resource('countries', CountrieController::class);

        // districts resource route
        Route::get('districts/showByCountrys/{id}', 'App\Http\Controllers\admin\api\DistrictController@showByCountry');
        Route::resource('districts', DistrictController::class);

        // thanas resource route
        Route::get('thanas/showByDistricts/{id}','App\Http\Controllers\admin\api\ThanaController@showByDistrict');
        Route::resource('thanas', ThanaController::class);

        // Customer resource route
        Route::get('customers/search/{keyword}', 'App\Http\Controllers\admin\api\CustomerController@search');
        Route::put('customers/updateStatus/{id}', 'App\Http\Controllers\admin\api\CustomerController@updateStatus');
        Route::put('customers/updateVerify/{id}', 'App\Http\Controllers\admin\api\CustomerController@updateVerify');
        Route::resource('customers', CustomerController::class);


        // Status resource route
        Route::resource('statuses', StatusController::class);

        // colors resource route
        Route::resource('colors', ColorController::class);

        // Size resource route
        Route::resource('sizes', SizeController::class);

        // brands resource route
        Route::resource('brands', BrandController::class);

        // Aboutus resource route
        Route::resource('about_us', AboutUsController::class);

        // social_link resource route
        Route::resource('social_link', SocialLinkController::class);

        // categories resource route
        Route::resource('categories', CategoryController::class);

        Route::get('categories/showByParent/{id}', 'App\Http\Controllers\admin\api\CategoryController@showByParent');
        Route::get('categories/showByLevel/{id}', 'App\Http\Controllers\admin\api\CategoryController@showByLevel');

        // icons resource route
        Route::resource('icons', IconController::class);

        // icontype resource route
        Route::resource('icontype', IconTypeController::class);

        // units resource route
        Route::resource('units', UnitController::class);

        // Product resource route
        Route::resource('products', ProductController::class);

        Route::get('products/showbystatus/{id}', 'App\Http\Controllers\admin\api\ProductController@showbystatus');
        Route::get('products/showbycatagory/{id}', 'App\Http\Controllers\admin\api\ProductController@showbycatagory');

        Route::get('products/showbycatagoryandstatus/{cat_id}/{stat_id}', 'App\Http\Controllers\admin\api\ProductController@showbycatagoryandstatus');

        Route::post('products/delete_image/{imgid}/{image}', 'App\Http\Controllers\admin\api\ProductController@delete_destroy');

        // Banners resource route
        Route::resource('banners', BannerController::class);

        // Adv resource route
        Route::resource('advs', AdvController::class);

        // Faq resource route
        Route::resource('faqs', FaqController::class);

        // Vendor resource route
        Route::resource('vendors', VendorController::class);

        // Shipper resource route
        Route::resource('shippers', ShipperController::class);

        // Language resource route
        Route::resource('languages', LanguageController::class);

        // SmsSetupController resource route
        Route::resource('smssetups', SmsSetupController::class);

        Route::post('testsms','App\Http\Controllers\admin\api\SmsTestController@test');

        // SmsTemplate resource route
        Route::resource('smstemplates', SmsTemplateController::class);

        // EmailSetupController resource route
        Route::resource('emailsetups', EmailSetupController::class);
        Route::post('testemail','App\Http\Controllers\admin\api\EmailTestController@test');
        Route::post('composeEmail','App\Http\Controllers\admin\api\EmailTestController@composeEmail');

        // OrderStatusController resource route
        Route::resource('orderStatus', OrderStatusController::class);
     
        Route::post('orderstatus/param', 'App\Http\Controllers\admin\api\OrderStatusController@param');
        
        Route::post('orderstatus/paramMultiple', 'App\Http\Controllers\admin\api\OrderStatusController@paramMultiple');
        Route::post('orderstatus/paramonlyid', 'App\Http\Controllers\admin\api\OrderStatusController@paramonlyid');

        // OrderController resource route
        Route::resource('orders', OrderController::class);
        Route::post('orders/search', 'App\Http\Controllers\admin\api\OrderController@search');
        Route::post('orders/receive_payment', 'App\Http\Controllers\admin\api\OrderController@payment_update');
        Route::post('orders/order_confirm', 'App\Http\Controllers\admin\api\OrderController@order_confirm');
        Route::post('orders/order_ready', 'App\Http\Controllers\admin\api\OrderController@order_confirm');
        Route::post('orders/shiper_imform', 'App\Http\Controllers\admin\api\OrderController@shiper_imform');
        Route::post('orders/shipment_collect', 'App\Http\Controllers\admin\api\OrderController@shipment_collect');
        Route::post('orders/order_deliver', 'App\Http\Controllers\admin\api\OrderController@order_deliver');

        // OrderController resource route
        Route::resource('company_setup', CompanySetupController::class);

        // Theme resource route
        Route::resource('themes', ThemeController::class);

        // currencies resource route
        Route::resource('currencies', CurrencyController::class);

        // BusinessTypeController resource route
        Route::resource('businesstypes', BusinessTypeController::class);

        Route::resource('sliders', SliderController::class);

        Route::resource('slider_details', SliderImageController::class);
        Route::resource('slider_backgrounds', SliderBackgroundController::class);

        Route::resource('smslogs', SmsLogController::class);
        Route::post('smslogs/search', 'App\Http\Controllers\admin\api\SmsLogController@search');

        Route::resource('tags', TagController::class);
        Route::resource('emailtemplates', EmailTemplateController::class);

        Route::resource('emaillogs', EmailLogController::class);
        Route::post('emaillogs/search', 'App\Http\Controllers\admin\api\EmailLogController@search');

        Route::resource('parameters', ParameterController::class);
        Route::resource('homeconfigs', HomePageConfigController::class);
        Route::resource('footers', FooterController::class);
        Route::resource('paymentstatuses', PaymentStatusController::class);
        Route::resource('paymentmethods', PaymentMethodController::class);
        Route::resource('paymenticons', PaymentIconController::class);
        Route::resource('metatags', MetaTagController::class);
        Route::resource('pagecontents', PagesContentController::class);

        Route::resource('sponsorads', SponsorAdController::class);
        

        Route::resource('productreceives', MasMatReceiveController::class);
        Route::post('productreceives/search', 'App\Http\Controllers\admin\api\MasMatReceiveController@search');
        
        Route::resource('thirdpartyauths', ThirdpartyAuthController::class);

        

        Route::resource('smsallocations', SmsAllocationController::class);
        Route::post('smsallocations/search', 'App\Http\Controllers\admin\api\SmsAllocationController@search');
        Route::resource('onlinepayments', OnlinePaymentController::class);
        Route::post('onlinepayments/search', 'App\Http\Controllers\admin\api\OnlinePaymentController@search');
        Route::post('report/productsreceive', 'App\Http\Controllers\admin\api\ReportController@productreceive');
        Route::post('report/productstock', 'App\Http\Controllers\admin\api\ReportController@productstock');
        Route::post('report/sales', 'App\Http\Controllers\admin\api\ReportController@sales');
        Route::post('report/salesreturn', 'App\Http\Controllers\admin\api\ReportController@salesreturn');

        Route::post('report/suscribe', [SubscribeController::class, 'param']);
        Route::post('report/contactus', [ContactController::class, 'param']);

        Route::resource('userguides', UserGuideController::class);
        Route::resource('userprofiles', UserProfileController::class);
        Route::resource('contactpage', ContactPageInfoController::class);
        Route::resource('csses', CssController::class);
        Route::resource('levels', LevelController::class);
        Route::resource('news', NewsController::class);
        Route::resource('paymentoptions', PaymentOptionController::class);
        Route::resource('packsizes', PackSizeController::class);
        Route::resource('customertypes', CustomerTypeController::class);
        Route::resource('pickuplocations', PickupLocationController::class);
        Route::resource('resultcodes', ResultCodeController::class);
        Route::resource('fbmassengers', FbMassengerController::class);
        Route::resource('translogs', TransLogController::class);
        Route::resource('treemenu', TreeEntryController::class);
        Route::resource('producttags', ProductTagController::class);
        Route::resource('promotions', PromotionController::class);        
        Route::resource('profilepermission', ProfilePermissionController::class);

        Route::post('profilepermission/update', 'App\Http\Controllers\admin\api\ProfilePermissionController@pupdate');

        Route::get('buildmenu', [TreeEntryController::class, 'treemenu']);

        Route::post('userguideparam', [UserGuideController::class, 'param']);

        Route::post('dashboard/orderstatus', [DashboardController::class, 'status']);
        Route::post('dashboard/sale', [DashboardController::class, 'sale']);
        Route::post('dashboard/purchase', [DashboardController::class, 'purchase']);
        Route::post('dashboard/topbar', [DashboardController::class, 'topbardata']);
        Route::post('dashboard/sms', [DashboardController::class, 'sms']);
        Route::post('dashboard/email', [DashboardController::class, 'email']);
        Route::post('dashboard/bestproduct', [DashboardController::class, 'bestsaleproduct']);
        Route::post('dashboard/bestclient', [DashboardController::class, 'bestclient']);
        Route::post('dashboard/collection', [DashboardController::class, 'collection']);
        
        Route::post('productimport/import', [ProductImportController::class, 'import']);
        Route::post('productimport/synproduct', [ProductImportController::class, 'sysproduct']);
        Route::post('productimport/synproductbulk', [ProductImportController::class, 'sysproductbulk']);
        Route::post('productimport/deleteProduct', [ProductImportController::class, 'delete_product']);
        Route::resource('productimport',ProductImportController::class);
        Route::resource('productFilter',ProductFilterController::class);
        Route::post('productFilter/param', [ProductFilterController::class, 'param']);
        Route::post('productFilter/param_selected', [ProductFilterController::class, 'param_selected']);

    });

});

//Route::get('sponsorads/{id}', 'App\Http\Controllers\admin\api\SponsorAdController@show');

Route::get('homeconfig', [HomeConfigController::class, 'index']);
Route::post('homeconfig_param', [HomeConfigController::class, 'param']);
Route::get('parameter', [ParameterConfigController::class, 'index']);
Route::post('parameter_param', [ParameterConfigController::class, 'param']);
Route::post('size_param', [SizeController::class, 'param']);
Route::post('color_param', [ColorController::class, 'param']);
Route::post('brand_param', [BrandController::class, 'param']);
Route::post('company_param', [CompanySetupController::class, 'param']);
Route::post('social_param', [SocialLinkController::class, 'param']);
Route::post('slider_param', [SliderImageController::class, 'param']);
Route::post('sliderbackground_param', [SliderBackgroundController::class, 'param']);
Route::post('banner_param', [BannerController::class, 'param']);
Route::post('sponsor_param', [SponsorAdController::class, 'param']);
Route::post('paymenticon_param', [PaymentIconController::class, 'param']);
Route::post('footer_param', [FooterController::class, 'param']);
Route::post('producttag_param', [ProductTagController::class, 'param']);
Route::post('faq_param', [FaqController::class, 'param']);
Route::post('aboutUs', [AboutUsController::class, 'param']);
Route::post('category_param', [CategoryController::class, 'param']);

Route::post('category_paramFilter', [CategoryController::class, 'paramFilter']);

Route::post('category_ids', [CategoryController::class, 'getCatId']);
Route::post('productdetails', [ProductController::class, 'productdetails']);
Route::post('product_param', [ProductController::class, 'param']);
Route::post('country_param', [CountrieController::class, 'param']);
Route::post('district_param', [DistrictController::class, 'param']);
Route::post('thana_param', [ThanaController::class, 'param']);
Route::post('shipping_cost', [DistrictController::class, 'get_shipping_cost']);
Route::get('payment_options', [PaymentOptionController::class, 'status']);
Route::post('payment_search', [PaymentOptionController::class, 'payments']);
Route::post('news_param', [NewsController::class, 'param']);
Route::post('pagecontent_param', [PagesContentController::class, 'param']);


Route::resource('cart', CartController::class);
Route::post('cart/show', 'App\Http\Controllers\admin\api\CartController@show');
Route::post('cart/delete', 'App\Http\Controllers\admin\api\CartController@destroy');
Route::post('cart/update', 'App\Http\Controllers\admin\api\CartController@update');

Route::resource('wishlist', WishlistController::class);
Route::post('wishlist/show', 'App\Http\Controllers\admin\api\WishlistController@show');
Route::post('wishlist/delete', 'App\Http\Controllers\admin\api\WishlistController@destroy');

Route::resource('compare', CompareController::class);
Route::post('compare/show', 'App\Http\Controllers\admin\api\CompareController@show');
Route::post('compare/delete', 'App\Http\Controllers\admin\api\CompareController@destroy');

Route::prefix('customer')->group(function () {
    Route::post('register', [CustomerController::class, 'register']);
    Route::post('register_social', [CustomerController::class, 'register_social']);
    Route::post('login', [CustomerController::class, 'login']);
    Route::post('login_social', [CustomerController::class, 'login_social']);


    Route::middleware(['auth:customer'])->group(function () {
        Route::get('logout', [CustomerController::class, 'logout']);
        
        Route::post('getalldata', [CustomerController::class, 'getcustomerdata']);
        Route::post('getcust', [CustomerController::class, 'getcustomer']);
        Route::post('custupdate', [CustomerController::class, 'custupdate']);
        Route::post('review', [ProductReviewController::class, 'store']);
        
        Route::post('ordertrack', [OrderController::class, 'ordertrack']);
        Route::post('order/view', 'App\Http\Controllers\admin\api\OrderController@fontendshow');
        Route::post('order/store', 'App\Http\Controllers\admin\api\OrderController@fontendstore');
    });
});
Route::post('sociallogin/{provider}', 'App\Http\Controllers\Auth\AuthController@SocialSignup');
Route::get('auth/{provider}/callback', 'OutController@index')->where('provider', '.*');

Route::post('pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('reviewshow', [ProductReviewController::class, 'param']);
Route::post('subscribes', [SubscribeController::class, 'store']);
Route::post('contactus', [ContactController::class, 'store']);
Route::post('promotions_param', [PromotionController::class, 'param']);
Route::post('fbmassengers/param', [FbMassengerController::class, 'param']);
Route::post('meta/param', [MetaTagController::class, 'param']);
Route::post('cat/name', [CategoryController::class, 'getCatName']);
Route::post('thirdpartyauths/param', [ThirdpartyAuthController::class, 'param']);
Route::post('productfilter_param', [ProductFilterController::class, 'productfilter_param']);

Route::post('payment/param', [PaymentOptionController::class, 'param']);