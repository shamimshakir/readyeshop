<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\MasMatReceive;
use App\Models\TrnMatReceiveDetail;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\helper;

class MasMatReceiveController extends Controller
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

        $MasMatReceive = MasMatReceive::with('vendor','trnMatReceives','status')->get();
        if($MasMatReceive) {
            return response()->json(["status" => "success", "error" => false, "count" => count($MasMatReceive),"data" => $MasMatReceive], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no MasMatReceive found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no MasMatReceive found."], 404);
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
                "client_id"=> "required",
                "invoice_date"=> "required",
                "cat_id"=> "required|array",
                "prod_id"=> "required|array",
                "qty"=> "required|array",
                "unitprice"=> "required|array"
        ]);


        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {


           $invnum=pick("mas_mat_receives","max(invoice_number)","",'')+1;
           $total_bill=array_sum($request->total);
            $MasMatReceive = MasMatReceive::create([
                "invoice_date" => $request->invoice_date,
                "client_id" => $request->client_id,
                "invoice_number" => $invnum,
                "comments" => $request->comments,
                "total_bill" => $total_bill,
                "user_id" => Auth::user()->id
            ]);
            $MasMatReceive_id =  $MasMatReceive->id;

            foreach($request->cat_id as $i => $cat_ids ){
                $TrnMatReceiveDetail = TrnMatReceiveDetail::create([
                    "invoiceobject_id" =>$MasMatReceive_id,
                    "cat_id" => $cat_ids,
                    "prod_id" => $request->prod_id[$i],
                    "size_id" => $request->size_id[$i],
                    "color_id" => $request->color_id[$i],
                    "qty" => $request->qty[$i],
                    "rate" => $request->unitprice[$i],
                    "total" => $request->total[$i],
                    "user_id" => Auth::user()->id
                    ]);
            }


            return response()->json(["status" => "success", "error" => false, "message" => "Success! MasMatReceive created."], 201);

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
       $MasMatReceive = MasMatReceive::with('vendor','trnMatReceives','status')->where('mas_mat_receives.id', '=', $id)->get();

        if($MasMatReceive) {
            return response()->json(["status" => "success", "error" => false, "count" => count($MasMatReceive), "data" => $MasMatReceive], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no MasMatReceive found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no MasMatReceive found."], 404);
    }

public function search(Request $request)
    {

      $user = Auth::user();
        if($user!=''){
        

        $orders = MasMatReceive::with('vendor','trnMatReceives','status');
                if($request->vendor>0){
                    $orders = $orders->where('mas_mat_receives.client_id', '=', $request->vendor);
                }
                if($request->category>0){
                   $orders = $orders->whereHas('trnMatReceives', function($query) {
                        $query->where('trn_mat_receive_details.cat_id', '=', \Request::input('category'));
                    });
                }
                if($request->product>0){
                    $orders = $orders->whereHas('trnMatReceives', function($query) {
                        $query->where('trn_mat_receive_details.prod_id', '=', \Request::input('product'));
                    });
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
        $MasMatReceive = MasMatReceive::find($id);
        if($user!='' && $MasMatReceive){
            $validator = Validator::make($request->all(), [
                "client_id"=> "required",
                "invoice_date"=> "required",
                "cat_id"=> "required|array",
                "prod_id"=> "required|array",
                "qty"=> "required|array",
                "unitprice"=> "required|array"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
                $total_bill=array_sum($request->total);


                $MasMatReceive['invoice_date'] = $request->invoice_date;
                $MasMatReceive['client_id'] = $request->client_id;
                $MasMatReceive['comments'] = $request->comments;
                $MasMatReceive['total_bill'] = $total_bill;
                $MasMatReceive->save();

                 $trnmat = TrnMatReceiveDetail::where('invoiceobject_id', $id)->get(['id']);
                    if($trnmat) {
                        TrnMatReceiveDetail::destroy($trnmat->toArray());
                    }
                foreach($request->cat_id as $i => $cat_ids ){
                $TrnMatReceiveDetail = TrnMatReceiveDetail::create([
                        "invoiceobject_id" =>$id,
                        "cat_id" => $cat_ids,
                        "prod_id" => $request->prod_id[$i],
                        "size_id" => $request->size_id[$i],
                        "color_id" => $request->color_id[$i],
                        "qty" => $request->qty[$i],
                        "rate" => $request->unitprice[$i],
                        "total" => $request->total[$i],
                        "user_id" => Auth::user()->id
                        ]);
                }
             return response()->json(["status" => "success", "error" => false, "message" => "Success! MasMatReceive updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no MasMatReceive found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $MasMatReceive = Auth::user()->MasMatReceive->find($id);
        if($MasMatReceive) {
            $MasMatReceive->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! MasMatReceive deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no MasMatReceive found."], 404);
    }
}
