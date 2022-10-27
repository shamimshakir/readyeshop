<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\OnlinePayment;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class OnlinePaymentController extends Controller
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
        $orders = OnlinePayment::with('customer')->get();
        if($orders) {
            return response()->json(["status" => "success", "error" => false, "count" => count($orders),"data" => $orders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Online Payment found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Online Payment found."], 404);
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
        //
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

        $orders = OnlinePayment::with('customer')->where('online_payments.id', '=', $id)->get();

        if($orders) {
            return response()->json(["status" => "success", "error" => false, "count" => count($orders), "data" => $orders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Online Payment found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Online Payment found."], 404);
    }

    public function search(Request $request)
    {

      $user = Auth::user();
        if($user!=''){

        $orders = OnlinePayment::with('customer');
                if($request->customer_id>0){
                    $orders = $orders->Where('online_payments.cus_id', '=', $request->customer_id);
                }
                if($request->order_no!=''){
                    $orders = $orders->Where('online_payments.tran_id', 'like', '%' .$request->order_no . '%');
                }
                if($request->start_date!='' && $request->end_date!=''){
                    $orders = $orders->whereBetween('online_payments.tran_date', [$request->start_date,$request->end_date]);
                }
         $orders = $orders->get();

        if($orders) {
            return response()->json(["status" => "success", "error" => false,"count" => count($orders), "data" => $orders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Online Payment found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Online Payment found."], 404);
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
}
