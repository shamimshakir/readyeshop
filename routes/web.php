<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailerController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\OutController;
use App\Http\Controllers\admin\api\UserController;
use App\Http\Controllers\SitemapController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/{any}', 'App\Http\Controllers\PagesController@index')->where('any', '.*');

// Auth::routes();

Route::get('admin', [HomeController::class, 'admin'])->name('admin');
Route::get('', [HomeController::class, 'index']);
Route::get('about', [HomeController::class, 'about']);
Route::get('faq', [HomeController::class, 'faq']);
Route::get('contact', [HomeController::class, 'contact']);
Route::get('account/wishlist', [HomeController::class, 'wishlist']);
Route::get('account/compare', [HomeController::class, 'compare']);
Route::get('account/login', [HomeController::class, 'login']);
Route::get('account/register', [HomeController::class, 'register']);
Route::get('account/dashboard', [HomeController::class, 'dashboard']);
Route::get('account/profile', [HomeController::class, 'profile']);
Route::get('shop', [HomeController::class, 'shop']);
Route::get('checkout', [HomeController::class, 'checkout']);
Route::get('product/details/{name}', [HomeController::class, 'product']);
Route::get('category/{name}', [HomeController::class, 'category']);
Route::get('others/customer_service', [HomeController::class, 'customer_service']);
Route::get('others/terms_condition', [HomeController::class, 'terms_condition']);
Route::get('others/return_exchange', [HomeController::class, 'return_exchange']);
Route::get('NaN', [HomeController::class, 'nan']);
Route::get('nan', [HomeController::class, 'nan']);
Route::get('undefined', [HomeController::class, 'undefined']);
Route::get('product/details/undefined', [HomeController::class, 'undefined']);
Route::get('product/details/null', [HomeController::class, 'undefined']);

Route::post('sociallogin/{provider}', 'App\Http\Controllers\Auth\AuthController@SocialSignup');

Route::get('auth/{provider}/callback', 'OutController@index')->where('provider', '.*');


Route::get('/payment', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);
Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);

Route::get('/admin/login_others', [UserController::class, 'loginOthers']);


Route::get('/sitemap.xml', 'App\Http\Controllers\SitemapController@index')->name('sitemap.xml');
Route::get('/sitemap.xml/home', [SitemapController::class, 'home']);
Route::get('/sitemap.xml/contact', [SitemapController::class, 'contact']);
Route::get('/sitemap.xml/about', [SitemapController::class, 'about']);
Route::get('/sitemap.xml/faq', [SitemapController::class, 'faq']);
Route::get('/sitemap.xml/wishlist', [SitemapController::class, 'wishlist']);
Route::get('/sitemap.xml/compare', [SitemapController::class, 'compare']);
Route::get('/sitemap.xml/login', [SitemapController::class, 'login']);
Route::get('/sitemap.xml/customer_service', [SitemapController::class, 'customer_service']);
Route::get('/sitemap.xml/terms_condition', [SitemapController::class, 'terms_condition']);
Route::get('/sitemap.xml/return_exchange', [SitemapController::class, 'return_exchange']);
Route::get('/sitemap.xml/shop', [SitemapController::class, 'shop']);
Route::get('/sitemap.xml/category', [SitemapController::class, 'category']);
Route::get('/sitemap.xml/product', [SitemapController::class, 'product']);

Route::get('/robots.txt', 'App\Http\Controllers\RobotsControllers@index')->name('robots.txt');

Route::get('/clear', function() {
   Artisan::call('cache:clear --domain='.$_SERVER['SERVER_NAME'].'');
   Artisan::call('route:clear --domain='.$_SERVER['SERVER_NAME'].'');
   Artisan::call('config:clear --domain='.$_SERVER['SERVER_NAME'].'');
   Artisan::call('config:cache --domain='.$_SERVER['SERVER_NAME'].'');
   Artisan::call('optimize --domain='.$_SERVER['SERVER_NAME'].'');
   Artisan::call('view:clear --domain='.$_SERVER['SERVER_NAME'].'');
   return "Cleared!";

});
Route::get('/cache', function() {  
   Artisan::call('route:cache --domain='.$_SERVER['SERVER_NAME'].'');
   Artisan::call('config:cache --domain='.$_SERVER['SERVER_NAME'].'');
   Artisan::call('optimize --domain='.$_SERVER['SERVER_NAME'].'');
   Artisan::call('view:cache --domain='.$_SERVER['SERVER_NAME'].'');
   return "cache!";
});