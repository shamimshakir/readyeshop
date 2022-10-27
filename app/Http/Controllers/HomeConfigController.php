<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomePageConfig;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homepageconfigs = HomePageConfig::with('statuses')->get();
        if($homepageconfigs) {
            return response()->json(["status" => "success", "error" => false, "count" => count($homepageconfigs),"data" => $homepageconfigs], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }

    public function param(Request $request)
    {
        $homepageconfigs = HomePageConfig::with('statuses');

        if($request->id>0){
            $homepageconfigs = $homepageconfigs->where('home_page_configs.id', '=', $request->id);
        }
        if($request->status>0){
            $homepageconfigs = $homepageconfigs->Where('home_page_configs.status', '=', $request->status);
        }
        if($request->name!=''){
            $homepageconfigs = $homepageconfigs->Where('home_page_configs.name', '=', $request->name);
        }
        $homepageconfigs = $homepageconfigs->get();
        if($homepageconfigs) {
            return response()->json(["status" => "success", "error" => false, "count" => count($homepageconfigs),"data" => $homepageconfigs], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }

    
}
