<?php

namespace App\Http\Controllers\admin\api;

use App\Models\OrderStatus;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class OrderStatusController extends Controller
{
    public function index()
    {
        $user = Auth::user();
       if($user!=''){          
       
        $smssetups = OrderStatus::with('statues')
        ->orderBy('sl', 'ASC')->get();
        if($smssetups) {
            return response()->json(["status" => "success", "error" => false, "count" => count($smssetups),"data" => $smssetups], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order Status found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order Status found."], 404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            "ord_status" => "required|min:3|unique:order_statuses,ord_status",
            "sl" => "required",
            "icon" => "required",           
            "status" => "required"           
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $OrderStatus = OrderStatus::create([
                "ord_status" => $request->ord_status,
                "sl" => $request->sl,
                "icon" => $request->icon,               
                "status" => $request->status,               
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Order Status created."], 201);           
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
    public function show($id)
    {
       $user = Auth::user();
       if($user!=''){ 
        $order_status = OrderStatus::with('statues')->find($id);
       
        if($order_status) {
            return response()->json(["status" => "success", "error" => false, "data" => $order_status], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order Status found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order Status found."], 404); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $orderstatus = OrderStatus::find($id);
        if($user!='' && $orderstatus){
            $validator = Validator::make($request->all(), [  
                 "ord_status" => "required",
                 "sl" => "required",
                 "icon" => "required",
                 "status" => "required"
                ]);
            
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
               
            $order_status['ord_status'] = $request->ord_status;
            $orderstatus['sl'] = $request->sl;
            $orderstatus['icon'] = $request->icon;
            $orderstatus['status'] = $request->status;
            $orderstatus->save();
               
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Order Status updated."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Order Status found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order_status = Auth::user()->orderstatus->find($id);
        if($order_status) {
            $order_status->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Order Status deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Order Status found."], 404);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function param(Request $request)
    {
        
        $user = Auth::user();
        if($user!=''){ 
            $validator = Validator::make($request->all(), [
                 "status" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $order_status = OrderStatus::select('*');
            if($request->status!=''){
                $order_status = $order_status->Where('order_statuses.status', '=', $request->status);
            }
            $order_status = $order_status->orderBy('sl', 'ASC');
            $order_status = $order_status->get();
            
            if($order_status) {
                return response()->json(["status" => "success", "error" => false, "data" => $order_status], 200);
            }
                return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order Status found."], 404);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order Status found."], 404);
    }


    public function paramMultiple(Request $request)
    {
        
        $user = Auth::user();
        if($user!=''){ 
            $validator = Validator::make($request->all(), [
                 "status" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $order_status = OrderStatus::select('*');
            if(!empty($request->status)){
            $order_status = $order_status->whereIn('order_statuses.id', $request->status);
            }
            $order_status = $order_status->orderBy('sl', 'ASC')->get();
            
            if($order_status) {
                return response()->json(["status" => "success", "error" => false, "data" => $order_status], 200);
            }
                return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order Status found."], 404);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order Status found."], 404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paramonlyid(Request $request)
    {
        
        $user = Auth::user();
        if($user!=''){ 
            $validator = Validator::make($request->all(), [
                 "status" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $order_status = OrderStatus::select('*');
            if($request->status!=''){
                $order_status = $order_status->Where('order_statuses.status', '=', $request->status);
            }
            $order_status = $order_status->orderBy('sl', 'ASC');
            $order_status = $order_status->get()->pluck('id');
            
            if($order_status) {
                return response()->json(["status" => "success", "error" => false, "data" => $order_status], 200);
            }
                return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order Status found."], 404);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order Status found."], 404);
    }
}
