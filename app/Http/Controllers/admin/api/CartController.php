<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;

class CartController extends Controller
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
            "ct_qty" => "required",
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

            $product_price = pick('products','pd_price',"id",$request->pd_id);
            $product_tqty = pick('products','pd_qty',"id",$request->pd_id);
            $unit_price = $product_price * $request->ct_qty;


            $productCountCurrentSession = dcount('carts','pd_id',array('carts.ct_session_id'=>$request->session_id, 'carts.pd_id' => $request->pd_id));

            $productSessionQty = dsum('carts','ct_qty',array('carts.ct_session_id'=>$request->session_id, 'carts.pd_id' => $request->pd_id),'pd_id');
            $lqty=$productSessionQty+$request->ct_qty;
            if($product_tqty>=$lqty){
            
            if ($productCountCurrentSession == 0) {

            $carts = Cart::create([
                "pd_id" => $request->pd_id,
                "ct_session_id" => $request->session_id,
                "ct_qty" => $request->ct_qty,
                "size_id" => $request->size_id,
                "color_id" => $request->color_id,
                "cl_id" => $csid,
                "price" => $unit_price
                
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Product added to Cart ."], 201);
            }
            else{
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! Fail to add Cart."], 404);
            } 
            }else{
             return response()->json(["status" => "failed", "error" => true, "message" => "Failed! Product not aviable."], 404);   
            }

        }
        catch(Exception $exception) {
            return response()->json(["status" => "failed", "error" => $exception->getMessage()], 404);
        }
    }

    public function update(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            "pd_id" => "required",
            "ct_qty" => "required",
            "session_id" => "required",
            "id" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        $carts = Cart::find($request->id);

        try {

            $product_price = pick('products','pd_price',"id",$request->pd_id);
            $product_tqty = pick('products','pd_qty',"id",$request->pd_id);
            $unit_price = $product_price * $request->ct_qty;

            $productSessionQty = dsum('carts','ct_qty',array('carts.ct_session_id'=>$request->session_id, 'carts.pd_id' => $request->pd_id),'pd_id');
           
            $lqty=$request->ct_qty;

            if($product_tqty>=$lqty){

            $carts['ct_qty'] = $request->ct_qty;    
            $carts['price'] = $unit_price;

            $carts->save(); 

            return response()->json(["status" => "success", "error" => false, "message" => "Success! Cart Update Successfully."], 201);  
            }
            else{
             return response()->json(["status" => "failed", "error" => true, "message" => "Failed! Product not aviable."], 404);   
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
        $carts = Cart::with('customers','products','sizes','colors');
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';
        $condsarray=array();
        if($request->id>0){
            $carts = $carts->where('carts.id', '=', $request->id);
            $condsarray= array('carts.id'=>$request->id);
            
        }
        if($request->customer>0){
            $carts = $carts->Where('carts.cl_id', '=', $request->customer);
            $condsarray= array('carts.cl_id'=>$request->customer );
        }
        if($request->session_id!=''){
            $carts = $carts->Where('carts.ct_session_id', '=', $request->session_id);
            $condsarray= array('carts.ct_session_id'=>$request->session_id );
        }
        $carts = $carts->get();

        $total=0;
        $total=dsum('carts', 'price',$condsarray,'ct_session_id');

        //echo $carts ;
       // exit;
        if($carts) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl,"total"=>$total, "count" => count($carts),"data" => $carts], 200);
        }
         return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Cart found."], 404);
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $carts = Cart::select('id');
        if($request->id>0){
            $carts = $carts->where('carts.id', '=', $request->id);
        }
        if($request->customer>0){
            $carts = $carts->Where('carts.cl_id', '=', $request->customer);
        }
        if($request->session_id!=''){
            $carts = $carts->Where('carts.ct_session_id', '=', $request->session_id);
        }
        $carts = $carts->get();

        if($carts) {                     
            Cart::destroy($carts->toArray());         
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Cart deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Cart found."], 404);
    }



}
