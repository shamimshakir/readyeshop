<?php

namespace App\Http\Controllers\admin\api;

use App\Models\EmailLog;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmailLogController extends Controller
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
        $emaillogs = EmailLog::with('user','emailsetup')->get();
        if($emaillogs) {
            return response()->json(["status" => "success", "error" => false, "count" => count($emaillogs),"data" => $emaillogs], 200);
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

        $emaillogs = EmailLog::with('user','emailsetup');
                if($request->sms_is>0){
                    $emaillogs = $emaillogs->Where('email_logs.email_setup_id', '=', $request->email_setup_id);
                }
                if($request->email_status!=''){
                    $emaillogs = $emaillogs->Where('email_logs.email_status', 'like', '%' .$request->email_status. '%');
                }
                if($request->number!=''){
                    $emaillogs = $emaillogs->Where('email_logs.email', 'like', '%' .$request->email . '%');
                }
                if($request->start_date!='' && $request->end_date!=''){
                    $emaillogs = $emaillogs->whereBetween('email_logs.date_time', [$request->start_date,$request->end_date]);
                }
         $emaillogs = $emaillogs->get();
//print_r($emaillogs);
//exit;
        if($emaillogs) {
            return response()->json(["status" => "success", "error" => false,"count" => count($emaillogs), "data" => $emaillogs], 200);
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
