<?php

namespace App\Http\Controllers\admin\api;

use App\Models\SmsLog;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SmsLogController extends Controller
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
        $smslogs = SmsLog::with('user','smssetup')->get();
        if($smslogs) {
            return response()->json(["status" => "success", "error" => false, "count" => count($smslogs),"data" => $smslogs], 200);
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
        //
    }

    public function search(Request $request)
    {
      $user = Auth::user();
        if($user!=''){

        $smslogs = SmsLog::with('user','smssetup');
                if($request->sms_is>0){
                    $smslogs = $smslogs->Where('sms_logs.sms_setup_id', '=', $request->sms_is);
                }
                if($request->sms_status!=''){
                    $smslogs = $smslogs->Where('sms_logs.sms_status', 'like', '%' .$request->sms_status. '%');
                }
                if($request->number!=''){
                    $smslogs = $smslogs->Where('sms_logs.number', 'like', '%' .$request->number . '%');
                }
                if($request->start_date!='' && $request->end_date!=''){
                    $smslogs = $smslogs->whereBetween('sms_logs.date_time', [$request->start_date,$request->end_date]);
                }
         $smslogs = $smslogs->get();
// print_r($smslogs);
// exit;
        if($smslogs) {
            return response()->json(["status" => "success", "error" => false,"count" => count($smslogs), "data" => $smslogs], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
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
