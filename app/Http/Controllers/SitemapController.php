<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index() {     
      return response()->view('sitemap.index', [
      ])->header('Content-Type', 'text/xml');
    }

    public function home() {     
      return response()->view('sitemap.home', [
      ])->header('Content-Type', 'text/xml');
    }
    public function contact() {     
      return response()->view('sitemap.contact', [
      ])->header('Content-Type', 'text/xml');
    }
    public function faq() {     
      return response()->view('sitemap.faq', [
      ])->header('Content-Type', 'text/xml');
    }
    public function about() {     
      return response()->view('sitemap.about', [
      ])->header('Content-Type', 'text/xml');
    }
    public function wishlist() {     
      return response()->view('sitemap.wishlist', [
      ])->header('Content-Type', 'text/xml');
    }
    public function compare() {     
      return response()->view('sitemap.compare', [
      ])->header('Content-Type', 'text/xml');
    }
    public function login() {     
      return response()->view('sitemap.login', [
      ])->header('Content-Type', 'text/xml');
    }
    public function customer_service() {     
      return response()->view('sitemap.customer_service', [
      ])->header('Content-Type', 'text/xml');
    }
    public function terms_condition() {     
      return response()->view('sitemap.terms_condition', [
      ])->header('Content-Type', 'text/xml');
    }
    public function return_exchange() {     
      return response()->view('sitemap.return_exchange', [
      ])->header('Content-Type', 'text/xml');
    }
    public function shop() {     
      return response()->view('sitemap.shop', [
      ])->header('Content-Type', 'text/xml');
    }
    public function category() {
     $category = Category::where('act_status','=','1')->get();     
      return response()->view('sitemap.category', [
         'category' => $category,
      ])->header('Content-Type', 'text/xml');
    }
    public function product() {
    $product = Product::where('pd_status','=','1')->get();        
      return response()->view('sitemap.product', [
         'product' => $product,
      ])->header('Content-Type', 'text/xml');
    }
}