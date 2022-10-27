<?php

namespace App\Http\Controllers\admin\api;

use App\Models\PaymentStatus;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PaymentStatusController extends Controller
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
        $paymentstatuses = PaymentStatus::All();
        if($paymentstatuses) {
            return response()->json(["status" => "success", "error" => false, "count" => count($paymentstatuses),"data" => $paymentstatuses], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Payment Status found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Payment Status found."], 404);
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
            "name" => "required|min:3|unique:payment_statuses,name",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $paymentstatuses = PaymentStatus::create([
                "name" => $request->name,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Payment Status created."], 201);
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
       
        $paymentstatuses = PaymentStatus::find($id);
        if($paymentstatuses) {
            return response()->json(["status" => "success", "error" => false,"data" => $paymentstatuses], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Payment Status found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Payment Status found."], 404);
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
        $paymentstatuses = PaymentStatus::find($id);
        if($user!='' && $paymentstatuses){
            $validator = Validator::make($request->all(), [
                "name" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            $paymentstatuses['name'] = $request->name;
            $paymentstatuses->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Payment Status updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Payment Status found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentstatuses = Auth::user()->paymentstatuses->find($id);
        if($paymentstatuses) {
            $paymentstatuses->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Payment Status deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Payment Status found."], 404);
    }
}
