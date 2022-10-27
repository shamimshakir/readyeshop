<?php

namespace App\Http\Controllers\admin\api;

use App\Models\SmsAllocation;
use App\Models\SmsAllocationDetail;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class SmsAllocationController extends Controller
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
        $smssetups = SmsAllocationDetail::with('user')->get();
        if($smssetups) {
            return response()->json(["status" => "success", "error" => false, "count" => count($smssetups),"data" => $smssetups], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms setup found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms setup found."], 404);
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
            "name" => "required",
            "allocate_ammount" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $SmsAllocationDetail = SmsAllocationDetail::create([
                "name" => $request->name,
                "allocate_ammount" => $request->allocate_ammount,
                "allocation_date" => date('Y-m-d'),
                "user_id" => Auth::user()->id
            ]);
        $SmsAllocation = SmsAllocation::find(1);
        if($SmsAllocation){
           DB::statement("UPDATE
                         sms_allocations
                        SET
                          current_ammount = current_ammount+ $request->allocate_ammount,
                          allocate_ammount = allocate_ammount+ $request->allocate_ammount,
                          allocation_date = NOW(),
                          total = total+ $request->allocate_ammount
                        WHERE id=1");
        }else{
            $SmsAllocationDetail = SmsAllocation::create([
                "name" => $request->name,
                "current_ammount" => $request->allocate_ammount,
                "total" => $request->allocate_ammount,
                "allocation_date" => date('Y-m-d'),
                "user_id" => Auth::user()->id
            ]);
        }
            return response()->json(["status" => "success", "error" => false, "message" => "Success! sms setup created."], 201);           
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
       
        $smssetups = SmsAllocationDetail::with('user')->where('sms_allocation_details.id', '=', $id)->get();
        if($smssetups) {
            return response()->json(["status" => "success", "error" => false, "count" => count($smssetups),"data" => $smssetups], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms setup found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms setup found."], 404);
    }
    public function search(Request $request)
    {
       $user = Auth::user();
       if($user!=''){

        $smssetups = SmsAllocationDetail::with('user');
                if($request->start_date!='' && $request->end_date!=''){
                    $smssetups = $smssetups->whereBetween('sms_allocation_details.allocation_date', [$request->start_date,$request->end_date]);
                }
        $smssetups = $smssetups->get();
        if($smssetups) {
            return response()->json(["status" => "success", "error" => false, "count" => count($smssetups),"data" => $smssetups], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms setup found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms setup found."], 404);
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
        $smssetups = Auth::user()->smssetups->find($id);
        if($smssetups) {
            $smssetups->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! sms setup deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no sms setup found."], 404);
    }
}
