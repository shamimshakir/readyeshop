<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Compare;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;

class CompareController extends Controller
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

            $productCountCurrentSession = dcount('compares','pd_id', array('compares.session_id'=>$request->session_id, 'compares.pd_id' => $request->pd_id));
            $pre_rpduct=pick('compares','pd_id',"session_id", $request->session_id);
            if($pre_rpduct!=''){
            $pre_cat=pick('products','category_id',"id",$pre_rpduct); 
            $cur_cat=pick('products','category_id',"id",$request->pd_id);
                if($pre_cat!=$cur_cat){
                    return response()->json(["status" => "failed", "error" => true, "message" => "Failed! You can't compare this poduct"], 404);
                }
            }
            if ($productCountCurrentSession == 0) {
            $tags = Compare::create([
                "pd_id" => $request->pd_id,
                "session_id" => $request->session_id,
                "customer_id" => $csid
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Product Is successfully added to your Compare list."], 201);
            }else{
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! Fail to add compare."], 404);
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
        $comparelists = Compare::with('customers','products');
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';
        if($request->id>0){
            $comparelists = $comparelists->where('compares.id', '=', $request->id);
        }
        if($request->customer>0){
            $comparelists = $comparelists->Where('compares.customer_id', '=', $request->customer);
        }
        if($request->session_id!=''){
            $comparelists = $comparelists->Where('compares.session_id', '=', $request->session_id);
        }
        $comparelists = $comparelists->get();
        //echo $comparelists ;
       // exit;
        if($comparelists) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl, "count" => count($comparelists),"data" => $comparelists], 200);
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
       $comparelists = Compare::select('id');
        if($request->id>0){
            $comparelists = $comparelists->where('compares.id', '=', $request->id);
        }
        if($request->customer>0){
            $comparelists = $comparelists->Where('compares.customer_id', '=', $request->customer);
        }
        if($request->session_id!=''){
            $comparelists = $comparelists->Where('compares.session_id', '=', $request->session_id);
        }
        $comparelists = $comparelists->get();

        if($comparelists) {                     
            Compare::destroy($comparelists->toArray());         
            return response()->json(["status" => "success", "error" => false, "message" => "Success! product deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no product found."], 404);
    }
}
