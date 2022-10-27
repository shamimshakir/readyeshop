<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Customer;
use App\Models\MasMatReceive;
use App\Models\SmsLog;
use App\Models\EmailLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    
    public function topbardata(Request $request)
    {
        $user = Auth::user();
        if($user!=''){ 

            $orders = Order::select(DB::raw('
                SUM(IF(od_status=1, "1", "0")) as New_Order,
                SUM(IF(od_status=1, total_cost, "0")) as New_total,
                SUM(IF(od_status=3, "1", "0")) as Delivered,
                SUM(IF(od_status=3, total_cost, "0")) as Delivered_total,
                SUM(IF(od_status=5, "1", "0")) as Cancelled,
                SUM(IF(od_status=5, total_cost, "0")) as Cancelled_total,
                SUM(IF(od_status=4, "1", "0")) as Returned,
                SUM(IF(od_status=4, total_cost, "0")) as Returned_total'
            ))->get();

            $customer = Customer::select(DB::raw('count(customers.id) as CustomerTotal'));
            if($request->start_date!='' && $request->end_date!=''){
                $customer = $customer->whereBetween('customers.created_at', [$request->start_date,$request->end_date]);
            }           
            $customer = $customer->get();

            $mats = MasMatReceive::select(DB::raw('sum(mas_mat_receives.total_bill) as ptotal'),DB::raw('sum(trn_mat_receive_details.qty) as pqty'))
            ->leftJoin('trn_mat_receive_details', 'trn_mat_receive_details.invoiceobject_id', '=', 'mas_mat_receives.id')
            ->get();

            $product = Product::select(DB::raw('SUM(`pd_qty`) as qtys'),DB::raw('SUM(pd_price*pd_qty) as total'));                 
            $product = $product->get();

            $collection = Order::select(DB::raw('SUM(`total_cost`) as tcollection'))
            ->where('payment_status','=',1)
            ->get();

            $array = array_merge($orders->toArray(), $customer->toArray(), $mats->toArray(),$product->toArray(),$collection->toArray());

            if($orders) {
                return response()->json(["status" => "success", "error" => false,"data" => $array], 200);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
            }
         return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);   

    }

    public function status(Request $request)
    {
        $user = Auth::user();
        if($user!=''){             
            $orders = OrderStatus::select('order_statuses.ord_status', DB::raw('count(orders.id) as total'))
            ->leftJoin('orders', 'order_statuses.id', '=', 'orders.od_status');
            if($request->start_date!='' && $request->end_date!=''){
                $orders = $orders->whereBetween('orders.od_date', [$request->start_date,$request->end_date]);
            }
            $orders = $orders->groupBy('order_statuses.id')
            ->get();
            if($orders) {
                return response()->json(["status" => "success", "error" => false,"count" => count($orders), "data" => $orders], 200);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
            }
         return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);        
    }

    public function sale(Request $request)
    {
        $user = Auth::user();
        if($user!=''){             
            $orders = Order::select(DB::raw("DATE_FORMAT(orders.od_date, '%d-%b') as od_date"), DB::raw('count(orders.id) as total'),DB::raw('sum(orders.total_cost) as total_cost'));
            if($request->start_date!='' && $request->end_date!=''){
                $orders = $orders->whereBetween('orders.od_date', [$request->start_date,$request->end_date]);
            }
            $orders = $orders->groupBy('orders.od_date')
            ->orderBy('orders.od_date','DESC')
            ->get();
            if($orders) {
                return response()->json(["status" => "success", "error" => false,"count" => count($orders), "data" => $orders], 200);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
            }
         return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);        
    }

    public function purchase(Request $request)
    {
        $user = Auth::user();
        if($user!=''){             
            $mats = MasMatReceive::select(DB::raw("DATE_FORMAT(mas_mat_receives.invoice_date, '%d-%b') as invoice_date"), DB::raw('sum(mas_mat_receives.total_bill) as total'),DB::raw('sum(trn_mat_receive_details.qty) as qty'))
            ->leftJoin('trn_mat_receive_details', 'trn_mat_receive_details.invoiceobject_id', '=', 'mas_mat_receives.id');
            if($request->start_date!='' && $request->end_date!=''){
                $mats = $mats->whereBetween('mas_mat_receives.invoice_date', [$request->start_date,$request->end_date]);
            }
            $mats = $mats->groupBy('mas_mat_receives.invoice_date')
            ->orderBy('mas_mat_receives.invoice_date','DESC')
            ->get();
            if($mats) {
                return response()->json(["status" => "success", "error" => false,"count" => count($mats), "data" => $mats], 200);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
            }
         return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);        
    }

    public function sms(Request $request)
    {
      $user = Auth::user();
        if($user!=''){

        $smslogs = SmsLog::select('*');               
        if($request->start_date!='' && $request->end_date!=''){
            $smslogs = $smslogs->whereBetween('sms_logs.date_time', [$request->start_date,$request->end_date]);
        }
        $smslogs = $smslogs->orderBy('sms_logs.date_time', 'DESC');
        $smslogs = $smslogs->get();


        if($smslogs) {
            return response()->json(["status" => "success", "error" => false,"count" => count($smslogs), "data" => $smslogs], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }

     public function email(Request $request)
    {
      $user = Auth::user();
        if($user!=''){
        $emaillogs = EmailLog::select('*');               
        if($request->start_date!='' && $request->end_date!=''){
            $emaillogs = $emaillogs->whereBetween('email_logs.date_time', [$request->start_date,$request->end_date]);
        }
        $emaillogs = $emaillogs->orderBy('email_logs.date_time', 'DESC');        
        $emaillogs = $emaillogs->get();
        if($emaillogs) {
            return response()->json(["status" => "success", "error" => false,"count" => count($emaillogs), "data" => $emaillogs], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }


    public function bestsaleproduct(Request $request)
    {
        $user = Auth::user();
        if($user!=''){             
            $orders = Order::select('products.pd_name' ,DB::raw('sum(order_items.od_qty) as qty'))
            ->leftJoin('order_items', 'order_items.od_id', '=', 'orders.id')
            ->leftJoin('products', 'products.id', '=', 'order_items.pd_id');
            if($request->start_date!='' && $request->end_date!=''){
                $orders = $orders->whereBetween('orders.od_date', [$request->start_date,$request->end_date]);
            }
            $orders = $orders->groupBy('order_items.pd_id')
            ->orderByRaw('sum(order_items.od_qty) DESC')
            ->get();

            if($orders) {
                return response()->json(["status" => "success", "error" => false,"count" => count($orders), "data" => $orders], 200);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
            }
         return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);        
    }

    public function bestclient(Request $request)
    {
        $user = Auth::user();
        if($user!=''){             
            $orders = Order::select('customers.firstname' , DB::raw('count(orders.id) as total'))
            ->leftJoin('customers', 'customers.id', '=', 'orders.cl_id');            
            if($request->start_date!='' && $request->end_date!=''){
            $orders = $orders->whereBetween('orders.od_date', [$request->start_date,$request->end_date]);
            }
            $orders = $orders->groupBy('orders.cl_id')
            ->orderByRaw('count(orders.id) DESC')
            ->get();

            if($orders) {
                return response()->json(["status" => "success", "error" => false,"count" => count($orders), "data" => $orders], 200);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
            }
         return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);        
    }

    public function collection(Request $request)
    {
        $user = Auth::user();
        if($user!=''){             
            $orders = Order::select(DB::raw("DATE_FORMAT(orders.od_payment_date, '%d-%b') as od_payment_date"), DB::raw('count(orders.id) as total'),DB::raw('sum(orders.total_cost) as total_cost'))
            ->where('payment_status','=','1')
            ->where('od_payment_date','<>',NULL);
            if($request->start_date!='' && $request->end_date!=''){
                $orders = $orders->whereBetween('orders.od_payment_date', [$request->start_date,$request->end_date]);
            }
            $orders = $orders->groupBy('orders.od_payment_date')
            ->orderBy('orders.od_payment_date','DESC')
            ->get();

            if($orders) {
                return response()->json(["status" => "success", "error" => false,"count" => count($orders), "data" => $orders], 200);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
            }
         return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);        
    }

}
