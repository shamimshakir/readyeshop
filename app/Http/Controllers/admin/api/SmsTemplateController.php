<?php

namespace App\Http\Controllers\admin\api;

use App\Models\SmsTemplate;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SmsTemplateController extends Controller
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
       
        $smstemplates = SmsTemplate::with('statuses')->get();
        if($smstemplates) {
            return response()->json(["status" => "success", "error" => false, "count" => count($smstemplates),"data" => $smstemplates], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms template found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms sms template found."], 404);
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
            "command" => "required|min:3|unique:sms_templates,command",
            "description" => "required",
            "status" => "required"          
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $smstemplates = SmsTemplate::create([
                "command" => $request->command,
                "description" => $request->description,
                "type" => $request->type,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! sms template created."], 201);           
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
       
        $smstemplates = SmsTemplate::with('statuses')->where('sms_templates.id', '=', $id)->get();
        if($smstemplates) {
            return response()->json(["status" => "success", "error" => false, "count" => count($smstemplates),"data" => $smstemplates], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms template found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms template found."], 404);
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
        $smstemplates = SmsTemplate::find($id);
        if($user!='' && $smstemplates){
            $validator = Validator::make($request->all(), [
                "command" => "required",
                "description" => "required",
                "status" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $smstemplates['command'] = $request->command;
            $smstemplates['description'] = $request->description;
            $smstemplates['status'] = $request->status;
            $smstemplates['type'] = $request->type;
            $smstemplates->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! sms template updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no sms template found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $smstemplates = Auth::user()->smstemplates->find($id);
        if($smstemplates) {
            $smstemplates->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! sms template deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no sms template found."], 404);
    }
}
