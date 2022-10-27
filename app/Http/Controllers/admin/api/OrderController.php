<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\CompanySetup;
use App\Models\Shipper;
use App\Models\OrderHistory;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
       if($user!=''){
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';
        $orders = Order::with('orderstatus','customer','thana','orderitems','orderhistorys','latestStatus')->get();
        if($orders) {
            return response()->json(["status" => "success", "error" => false, "count" => count($orders),'url'=>$pdimageurl,"data" => $orders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no orders found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no orders found."], 404);
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
                "cl_id"=> "required",
                "order_payment_method"=> "required",
                "product_cost"=> "required",
                "total_cost"=> "required",
                "od_shipping_cost"=> "required",
                "od_shipping_first_name"=> "required",
                "od_shipping_email"=> "required",
                "od_shipping_phone"=> "required",
                "od_shipping_address1"=> "required",
                "od_shipping_postal_code"=> "required",
                "od_shipping_country"=> "required",
        ]);


        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
        $companysetups= pick('company_setups', 'company_name', null, null); 
        $date = date( 'dmy' );        
        $shopName = strtoupper( substr( $companysetups, 0, 3 ) );
        $random = rand( 0000, 9999 );
        $od_no = $shopName . $date . $random;
            $order = Order::create([
                "od_no" => $od_no,
                "od_date" => date('Y-m-d H:i:s'),
                "cl_id" => $request->cl_id,
                "od_date" => $request->od_date,
                "order_payment_method" => $request->order_payment_method,
                "product_cost" => $request->product_cost,
                "total_cost" => $request->total_cost,
                "od_shipping_cost" => $request->od_shipping_cost,
                "od_payment_first_name" => $request->od_payment_first_name,
                "od_payment_email" => $request->od_payment_email,
                "od_payment_phone" => $request->od_payment_phone,
                "od_payment_country" => $request->od_payment_country,
                "od_payment_address1" => $request->od_payment_address1,
                "od_payment_postal_code" => $request->od_payment_postal_code,
                "od_payment_city" => $request->od_payment_city,
                "od_payment_thana" => $request->od_payment_thana,
                "od_shipping_first_name" => $request->od_shipping_first_name,
                "od_shipping_email" => $request->od_shipping_email,
                "od_shipping_phone" => $request->od_shipping_phone,
                "od_shipping_address1" => $request->od_shipping_address1,
                "od_shipping_address2" => $request->od_shipping_address2,
                "od_shipping_postal_code" => $request->od_shipping_postal_code,
                "od_shipping_country" => $request->od_shipping_country,
                "od_shipping_thana" => $request->od_shipping_thana,
                "od_shipping_city" => $request->od_shipping_city,
                "user_id" => Auth::user()->id
            ]);
            $order_id =  $order->id;

            foreach($request->pd_id as $i => $pids ){
               // echo $pids.$request->od_qty[$i];
                $orderitem = OrderItem::create([
                    "od_id" =>$order_id,
                    "pd_id" => $pids,
                    "od_qty" => $request->od_qty[$i],
                    "size_id" => $request->size_id[$i],
                    "color_id" => $request->color_id[$i],
                    "pd_price" => $request->pd_price[$i],
                    "user_id" => Auth::user()->id
                    ]);
            }
             $orderhistory = OrderHistory::create([
                    "od_id" =>$order_id,
                    "status" => '1',
                    "comments" => 'Order Placed',
                    "user_id" => Auth::user()->id
                    ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Order created."], 201);

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
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';
        $orders = Order::with('orderstatus','customer','thana','orderitems','orderhistorys','latestStatus')->where('orders.id', '=', $id)->get();

        if($orders) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl, "count" => count($orders), "data" => $orders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }

    public function search(Request $request)
    {
       
      $user = Auth::user();
        if($user!=''){
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';

        $orders = Order::with('orderstatus','customer','thana','orderitems','orderhistorys','latestStatus');
                if($request->status>0){
                    $orders = $orders->where('orders.od_status', '=', $request->status);
                }
                if($request->customer_id>0){
                    $orders = $orders->Where('orders.cl_id', '=', $request->customer_id);
                }
                if($request->order_no!=''){
                    $orders = $orders->Where('orders.od_no', 'like', '%' .$request->order_no . '%');
                }
                if($request->start_date!='' && $request->end_date!=''){
                    $orders = $orders->whereBetween('orders.od_date', [$request->start_date,$request->end_date]);
                }
         $orders = $orders->get();

        if($orders) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl,"count" => count($orders), "data" => $orders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
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
        //
    }

    public function payment_update(Request $request)
    {
        $user = Auth::user();
        $order = Order::find($request->id);
        $paid= pick('orders', 'payment_status', "orders.id", $request->id);
        if($paid==0){
        if($user!='' && $order){
            $validator = Validator::make($request->all(), [
                "id" => "required",
                "payment_status" => "required",
                "od_payment_amount" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            $order['id'] = $request->id;
            $order['od_payment_date'] =date('Y-m-d H:i:s');
            $order['payment_status'] = $request->payment_status;
            $order['od_payment_amount'] = $request->od_payment_amount;
            $order['od_payment_update_by'] = Auth::user()->id;
            $order->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Order Payment updated."], 201);
        }
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Order found."], 404);
    }

    public function order_confirm(Request $request)
    {
        $user = Auth::user();
        $order = Order::find($request->id);
        if($user!='' && $order){
            $validator = Validator::make($request->all(), [
                "id" => "required",
                "od_status" => "required",
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            $order['od_last_update'] =date('Y-m-d H:i:s');
            $order['od_status'] = $request->od_status;
            $order['status_change_comment'] = $request->status_change_comment;
            $order->save();

             $orderhistory = OrderHistory::create([
                    "od_id" =>$request->id,
                    "status" => $request->od_status,
                    "comments" => $request->status_change_comment,
                    "user_id" => Auth::user()->id
                    ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Order Status updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Order found."], 404);
    }

    public function shiper_imform(Request $request)
    {
        $user = Auth::user();
        $order = Order::find($request->id);
        if($user!='' && $order){
            $validator = Validator::make($request->all(), [
                "id" => "required",
                "od_status" => "required",
                 "shipper_id" => "required",
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            $order['od_last_update'] =date('Y-m-d H:i:s');
            $order['od_status'] = $request->od_status;
            $order['shipper_id'] = $request->shipper_id;
            $order['status_change_comment'] = $request->status_change_comment;
            $order->save();

             $orderhistory = OrderHistory::create([
                    "od_id" =>$request->id,
                    "status" => $request->od_status,
                    "shiper_id" => $request->shipper_id,
                    "comments" => $request->status_change_comment,
                    "user_id" => Auth::user()->id
                    ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Order Status updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Order found."], 404);
    }

    public function shipment_collect(Request $request)
    {
      
        $user = Auth::user();
        $order = Order::find($request->id);
        if($user!='' && $order){
            $validator = Validator::make($request->all(), [
                "id" => "required",
                "od_status" => "required",
                "shipper_collect" => "required",
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            
            $order['od_last_update'] =date('Y-m-d H:i:s');
            $order['ship_date'] =date('Y-m-d H:i:s');
            $order['shipper_collect_date'] =date('Y-m-d H:i:s');
            $order['od_status'] = $request->od_status;
            $order['shipper_collect'] = $request->od_status;
            $order['shipper_remark'] = $request->shipper_remark;
            if($request->traking_id !=''){
                $order['traking_id'] = $request->traking_id;
            }
            $order->save();

             $orderhistory = OrderHistory::create([
                    "od_id" =>$request->id,
                    "status" => $request->od_status,
                    "comments" => $request->shipper_remark,
                    "user_id" => Auth::user()->id
                    ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Order Status updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Order found."], 404);
    }

    public function order_deliver(Request $request)
    {
        $user = Auth::user();
        $order = Order::find($request->id);
        if($user!='' && $order){
            $validator = Validator::make($request->all(), [
                "id" => "required",
                "od_status" => "required",
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            $order['od_last_update'] =date('Y-m-d H:i:s');
            $order['od_delivary_date'] =date('Y-m-d H:i:s');
            $order['od_status'] = $request->od_status;
            $order['status_change_comment'] = $request->status_change_comment;
            $order->save();

             $orderhistory = OrderHistory::create([
                    "od_id" =>$request->id,
                    "status" => $request->od_status,
                    "comments" => $request->status_change_comment,
                    "user_id" => Auth::user()->id
                    ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Order Status updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Order found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function fontendstore(Request $request)
    {

       $validator = Validator::make($request->all(), [
                "order_payment_method"=> "required",
                "product_cost"=> "required",
                "total_cost"=> "required",
                "od_shipping_cost"=> "required",
                "od_shipping_first_name"=> "required",
                "od_shipping_email"=> "required",
                "od_shipping_phone"=> "required",
                "od_shipping_address1"=> "required",
                "od_shipping_country"=> "required",
                "od_shipping_thana"=> "required",
        ]);


        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
        $user = Auth::user();
        //print_r($user);
        if($user!=''){    
        $companysetups= pick('company_setups', 'company_name', null, null); 
        $date = date( 'dmy' );        
        $shopName = strtoupper( substr( $companysetups, 0, 3 ) );
        $random = rand( 0000, 9999 );
        $od_no = $shopName . $date . $random;

        $transaction_id=uniqid();
        $currency="BDT";

            $order = Order::create([
                "od_no" => $od_no,
                "od_date" => date('Y-m-d H:i:s'),
                "cl_id" => Auth::user()->id,
                "od_date" => $request->od_date,
                "order_payment_method" => $request->order_payment_method,
                "product_cost" => $request->product_cost,
                "total_cost" => $request->total_cost,
                "od_shipping_cost" => $request->od_shipping_cost,
                "od_payment_first_name" => $request->od_payment_first_name,
                "od_payment_email" => $request->od_payment_email,
                "od_payment_phone" => $request->od_payment_phone,
                "od_payment_country" => $request->od_payment_country,
                "od_payment_address1" => $request->od_payment_address1,
                "od_payment_postal_code" => $request->od_payment_postal_code,
                "od_payment_city" => $request->od_payment_city,
                "od_payment_thana" => $request->od_payment_thana,
                "od_shipping_first_name" => $request->od_shipping_first_name,
                "od_shipping_email" => $request->od_shipping_email,
                "od_shipping_phone" => $request->od_shipping_phone,
                "od_shipping_address1" => $request->od_shipping_address1,
                "od_shipping_address2" => $request->od_shipping_address2,
                "od_shipping_postal_code" => $request->od_shipping_postal_code,
                "od_shipping_country" => $request->od_shipping_country,
                "od_shipping_thana" => $request->od_shipping_thana,
                "od_shipping_city" => $request->od_shipping_city,
                "status" => 'Pending',
                "transaction_id" => $transaction_id,
                "currency" => $currency,
                "user_id" => Auth::user()->id,

            ]);
            $order_id =  $order->id;

            foreach($request->pd_id as $i => $pids ){
               // echo $pids.$request->od_qty[$i];
                $orderitem = OrderItem::create([
                    "od_id" =>$order_id,
                    "pd_id" => $pids,
                    "od_qty" => $request->od_qty[$i],
                    "size_id" => $request->size_id[$i],
                    "color_id" => $request->color_id[$i],
                    "pd_price" => $request->pd_price[$i],
                    "user_id" => Auth::user()->id
                    ]);
            }
             $orderhistory = OrderHistory::create([
                    "od_id" =>$order_id,
                    "status" => '1',
                    "comments" => 'Order Placed',
                    "user_id" => Auth::user()->id
                    ]);


        $orders = Order::with('orderstatus','customer','thana','citys','countrys','orderitems','orderhistorys')->where('orders.id', '=', $order_id)->get();

            return response()->json(["status" => "success", "error" => false, "Order" =>$order_id,"orders"=> $orders, "message" => "Success! Your Order Submitted successfully."], 201);
        }
        return response()->json(["status" => "failed", "error" => 'Fail. Please Login'], 404);
        }
        catch(Exception $exception) {
            return response()->json(["status" => "failed", "error" => $exception->getMessage()], 404);
        }
    }


    public function fontendshow(Request $request)
    {

        $user = Auth::user();
        //print_r($user);
        if($user!=''){
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';
        $orders = Order::with('orderstatus','customer','thana','orderitems','orderhistorys')->where('orders.id', '=', $request->id)->get();

        if($orders) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl, "count" => count($orders), "data" => $orders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }

    public function ordertrack(Request $request)
    {
        $validator = Validator::make($request->all(), [
                "order_no"=> "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        $user = Auth::user();        
        if($user!=''){
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';
        $orders = Order::with('orderstatus','customer','thana','orderitems','orderhistorys');

        if($request->order_no!=''){
            $orders = $orders->Where('orders.od_no', '=', $request->order_no);
        }
        $orders = $orders->get();

        $orderstatus = OrderStatus::select('*')->where('status','=','1')->get();


        if($orders) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl, "count" => count($orders), "data" => $orders,"odstatus"=>$orderstatus ], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! Please Login ."], 404);
    }

    
}
