<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Subscribe;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Http\helper;
use App\Http\emailhelper;

class SubscribeController extends Controller
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
        $subscribes = Subscribe::All();
        if($tags) {
            return response()->json(["status" => "success", "error" => false, "count" => count($subscribes),"data" => $subscribes], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no subscribes found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no subscribes found."], 404);
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
            "email" => "required|email|unique:subscribes,email"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
           $subscribes = Subscribe::create([
                "email" => $request->email,
                "status" => 1,

            ]);
            $email_id=pick('email_setups','id','status','1');
            $emaildata=pickall('email_templates', 'short_code', 'subscribe');
            
            foreach ($emaildata as $index => $da) {
                   $email_subject=$da->subject;
                   $email_body=$da->body;

                }
           
            SendMails($request->email,'',$email_subject, $email_body,'', $email_id);

            return response()->json(["status" => "success", "error" => false, "message" => "Thanks for subscribe"], 201);
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
        //
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

    public function param(Request $request)
    {
       $user = Auth::user();
       if($user!=''){
        $subscribes = Subscribe::select('*');
        if($request->email>0){
            $subscribes = $subscribes->where('subscribes.email', '=', $request->email);
        }
        
        if($request->start_date!='' && $request->end_date!=''){
            $subscribes = $subscribes->whereBetween('subscribes.created_at', [$request->start_date,$request->end_date]);
        }
        $subscribes = $subscribes->get();
        if($subscribes) {
            return response()->json(["status" => "success", "error" => false, "count" => count($subscribes),"data" => $subscribes], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no subscribes found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no subscribes found."], 404);
    }
}
