<?php

namespace App\Http\Controllers;

use App\Models\ShopUser;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ShopUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ShopUser = DB::table('shop_users')
             ->select(DB::raw(' id,
                                mobile,
                                email,
                                name,
                                req_date,
                                domain,
                                business_type,
                                address,
                                logo,
                                tocken,
                                status,
                                sub_domain,
                                server_status,
                                domain_type,
                                verify_date,
                                cstatus,
                                exp_date,
                                CONCAT("https://", IF(domain_type="dom", domain, CONCAT(sub_domain,".readyshop.cloud"))) as  url'))             ->where('shop_users.cstatus', '=', 1)
             ->get();
        
        return response()->json(["status" => "success", "error" => false, "count" => count($ShopUser), "data" => $ShopUser],200);
    }

    
}
