<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Wishlist;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "pd_id" => "required",
            "session_id" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $user = Auth::user();
            if ($user != '') {
                $csid= Auth::user()->id;
            }else{
                $csid=0;
            }

           $wishlists = Wishlist::select('id');
           $wishlists = $wishlists->Where('wishlists.pd_id', '=', $request->pd_id);
           $wishlists = $wishlists->Where('wishlists.session_id', '=', $request->session_id);
           $wishlists = $wishlists->count();

           if($wishlists<=0){
            $tags = Wishlist::create([
                "pd_id" => $request->pd_id,
                "session_id" => $request->session_id,
                "customer_id" =>$csid,
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Product Is successfully added to your wishlist."], 201);
           }else{
            return response()->json(["status" => "failed", "error" => $exception->getMessage(),"message" => "Product Is Fail to add your Wishlist."], 404);
           }


            
            
        }
        catch(Exception $exception) {
            return response()->json(["status" => "failed", "error" => $exception->getMessage()], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $wishlists = Wishlist::with('customers','products');
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';
        if($request->id>0){
            $wishlists = $wishlists->where('wishlists.id', '=', $request->id);
        }
        if($request->customer>0){
            $wishlists = $wishlists->Where('wishlists.customer_id', '=', $request->customer);
        }
        if($request->session_id!=''){
            $wishlists = $wishlists->Where('wishlists.session_id', '=', $request->session_id);
        }
        $wishlists = $wishlists->get();
        //echo $wishlists ;
       // exit;
        if($wishlists) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl, "count" => count($wishlists),"data" => $wishlists], 200);
        }
         return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Wishlist found."], 404);
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $wishlists = Wishlist::select('id');
        if($request->id>0){
            $wishlists = $wishlists->where('wishlists.id', '=', $request->id);
        }
        if($request->customer>0){
            $wishlists = $wishlists->Where('wishlists.customer_id', '=', $request->customer);
        }
        if($request->session_id!=''){
            $wishlists = $wishlists->Where('wishlists.session_id', '=', $request->session_id);
        }
        $wishlists = $wishlists->get();

        if($wishlists) {                     
            Wishlist::destroy($wishlists->toArray());         
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Wishlist deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Wishlist found."], 404);
    }
}
