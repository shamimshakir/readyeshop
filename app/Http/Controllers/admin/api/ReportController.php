<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasMatReceive;
use App\Models\TrnMatReceiveDetail;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;

class ReportController extends Controller
{

    public function index()
    {
        //
    }

    public function productreceive(Request $request)
    {
        $user = Auth::user();
        if($user!=''){


        $orders = MasMatReceive::with('trnMatReceives','status');
                if($request->vendor>0){
                    $orders = $orders->where('mas_mat_receives.client_id', '=', $request->vendor);
                }
                if($request->category>0){
                   $orders = $orders->whereHas('trnMatReceives', function($query) {
                        $query->where('trn_mat_receive_details.cat_id', '=', \Request::input('category'));
                    });
                    //$orders = $orders->Where('trn_mat_receive_details.cat_id', '=', $request->category);
                }
                if($request->product>0){
                    $orders = $orders->whereHas('trnMatReceives', function($query) {
                        $query->where('trn_mat_receive_details.prod_id', '=', \Request::input('product'));
                    });
                   // $orders = $orders->Where('trn_mat_receive_details.prod_id', '=', $request->product);
                }
                if($request->bill_no!=''){
                    $orders = $orders->Where('mas_mat_receives.invoice_number', 'like', '%' .$request->bill_no . '%');
                }
                if($request->start_date!='' && $request->end_date!=''){
                    $orders = $orders->whereBetween('mas_mat_receives.invoice_date', [$request->start_date,$request->end_date]);
                }
         $orders = $orders->get();
        if($orders) {
            return response()->json(["status" => "success", "error" => false,"count" => count($orders), "data" => $orders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! No Product Rec found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Product Rec found."], 404);
    }

    public function productstock(Request $request){
        $user = Auth::user();
        if($user!=''){
        $product = Product::with('Category','Brand','Unit','Status');
                if($request->cat_id>0){
                    $product = $product->where('products.category_id', '=', $request->cat_id);
                }
                if($request->pd_id>0){
                    $product = $product->where('products.id', '=', $request->pd_id);
                }
                if($request->stat_id>0){
                    $product = $product->where('products.pd_status', '=', $request->stat_id);
                }
               $product = $product->get();

        if($product) {
            return response()->json(["status" => "success", "error" => false,"count" => count($product), "data" => $product], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }

    public function sales(Request $request)
    {

      $user = Auth::user();
        if($user!=''){

        $orders = Order::with('orderstatus','orderitems')
                    ->whereNotIn('orders.od_status', [4,5]);
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
            return response()->json(["status" => "success", "error" => false,"count" => count($orders), "data" => $orders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
    }

    public function salesreturn(Request $request)
    {

      $user = Auth::user();
        if($user!=''){

        $orders = Order::with('orderstatus','orderitems')
                ->WhereIn('orders.od_status', [4,5]);
                if($request->customer_id>0){
                    $orders = $orders->Where('orders.cl_id', '=', $request->customer_id);
                }
                if($request->start_date!='' && $request->end_date!=''){
                    $orders = $orders->whereBetween('orders.od_date', [$request->start_date,$request->end_date]);
                }
                if($request->order_no!=''){
                    $orders = $orders->Where('orders.od_no', 'like', '%' .$request->order_no . '%');
                }
         $orders = $orders->get();
//echo $orders;
//exit;
        if($orders) {
            return response()->json(["status" => "success", "error" => false,"count" => count($orders), "data" => $orders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Order found."], 404);
    }

}
