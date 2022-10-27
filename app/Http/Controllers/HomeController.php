<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CompanySetup;
use App\Models\MetaTag;
use App\Models\FbMassenger;
use App\Models\Css;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin()
    {
        return view('app');
    }
    public function index()
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', 'home')->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get();
        $csses = Css::where('status','=','1')->get();
        return view('index',compact('companysetup','metatags','fbmassengers','compurl','csses'));
    }
    public function about(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get(); 
        $csses = Css::where('status','=','1')->get();      
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 

        
    }
    public function faq(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get();
        $csses = Css::where('status','=','1')->get();  
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function contact(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get(); 
        $csses = Css::where('status','=','1')->get();      
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function wishlist(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get(); 
        $csses = Css::where('status','=','1')->get();      
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function compare(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get(); 
        $csses = Css::where('status','=','1')->get();      
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function shop(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get();  
        $csses = Css::where('status','=','1')->get();     
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function customer_service(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get();  
        $csses = Css::where('status','=','1')->get();     
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function terms_condition(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get(); 
        $csses = Css::where('status','=','1')->get();      
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function return_exchange(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get();
        $csses = Css::where('status','=','1')->get();       
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function login(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get(); 
        $csses = Css::where('status','=','1')->get();      
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function register(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get();  
        $csses = Css::where('status','=','1')->get();     
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function dashboard(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get(); 
        $csses = Css::where('status','=','1')->get();      
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function profile(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get();   
        $csses = Css::where('status','=','1')->get();    
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function checkout(Request $request)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get();  
        $csses = Css::where('status','=','1')->get();     
        return view('template',compact('companysetup','metatags','fbmassengers','compurl','csses')); 
    }
    public function nan()
    {
        return view('404');
    }
    
    public function undefined()
    {
        return view('404');
    }
    public function product($name)
    {
        // $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';

        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();         
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get(); 

        $fname=str_replace("-"," ",$name);
        $products =Product::select('*');       
        $products = $products->where('products.pd_name', '=', $fname);
        $products = $products->get(); 
        $csses = Css::where('status','=','1')->get();
        return view('template',compact('products','companysetup','fbmassengers','compurl','csses')); 
    }
    public function category($name)
    {
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
       // $metatags = MetaTag::where('meta_tags.meta_page', '=', $request->path())->Where('meta_tags.status', '=','1')->get();
        $fbmassengers = FbMassenger::where('fb_massengers.status', '=', 1)->get(); 
       $csses = Css::where('status','=','1')->get();
        return view('template',compact('companysetup','fbmassengers','compurl','csses')); 
    }
}
