<?php

namespace App\Http\Controllers\admin\api;

use App\Models\SmsSetup;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SmsSetupController extends Controller
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
            $smssetups = SmsSetup::with('statuses')->get();
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
            "name" => "required|min:3|unique:sms_setups,name",
            "sms_url" => "required",
            "submit_param" => "required",
            "type" => "required",
            "status" => "required"            
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $smssetups = SmsSetup::create([
                "name" => $request->name,
                "sms_url" => $request->sms_url,
                "submit_param" => $request->submit_param,
                "return_param" => $request->return_param,
                "return_value_type" => $request->return_value_type,               
                "type" => $request->type,
                "status" => $request->status,                
                "user_id" => Auth::user()->id
            ]);
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
       
        $smssetups = SmsSetup::with('statuses')->where('sms_setups.id', '=', $id)->get();
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
        $user = Auth::user();
        $smssetups = SmsSetup::find($id);
        if($user!='' && $smssetups){
            $validator = Validator::make($request->all(), [                
                "name" => "required",
                "sms_url" => "required",
                "submit_param" => "required",
                "type" => "required",
                "status" => "required"
                ]);
            
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
               
            $smssetups['name'] = $request->name;
            $smssetups['sms_url'] = $request->sms_url;
            $smssetups['submit_param'] = $request->submit_param;
            $smssetups['return_value_type'] = $request->return_value_type;
            $smssetups['type'] = $request->type;
            $smssetups['status'] = $request->status;
            $smssetups->save();
               
            return response()->json(["status" => "success", "error" => false, "message" => "Success! sms setup updated."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no sms setup found."], 404);
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
