<?php

namespace App\Http\Controllers\admin\api;

use App\Models\EmailSetup;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;




class EmailSetupController extends Controller
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
       
        $emailsetups = EmailSetup::with('statuses')->get();
        if($emailsetups) {
            return response()->json(["status" => "success", "error" => false, "count" => count($emailsetups),"data" => $emailsetups], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no email setup found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no email setup found."], 404);
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
            "name" => "required|min:3|unique:email_setups,name",            
            "status" => "required"            
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $emailsetups = EmailSetup::create([
                "name" => $request->name,
                "port" => $request->port,
                "Username" => $request->Username,
                "Password" => $request->Password,
                "setFrom" => $request->setFrom,               
                "SMTPAuth" => $request->SMTPAuth,
                "Host" => $request->Host,
                "SMTPSecure" => $request->SMTPSecure,
                "addReplyTo" => $request->addReplyTo,
                "addCC" => $request->addCC,
                "addBCC" => $request->addBCC,
                "isHTML" => $request->isHTML,
                "Mailer" => $request->Mailer,
                "send_email" => $request->send_email,
                "status" => $request->status,               
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Email setup created."], 201);           
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
       
        $emailsetups = EmailSetup::with('statuses')->where('email_setups.id', '=', $id)->get();
        if($emailsetups) {
            return response()->json(["status" => "success", "error" => false, "count" => count($emailsetups),"data" => $emailsetups], 200);
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
        $emailsetups = EmailSetup::find($id);
        if($user!='' && $emailsetups){
            $validator = Validator::make($request->all(), [                
                "name" => "required",                
                "status" => "required"
                ]);
            
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
               
            $emailsetups['name'] = $request->name;
            $emailsetups['port'] = $request->port;
            $emailsetups['Username'] = $request->Username;
            $emailsetups['Password'] = $request->Password;
            $emailsetups['setFrom'] = $request->setFrom;
            $emailsetups['SMTPAuth'] = $request->SMTPAuth;
            $emailsetups['Host'] = $request->Host;
            $emailsetups['SMTPSecure'] = $request->SMTPSecure;
            $emailsetups['addReplyTo'] = $request->addReplyTo;
            $emailsetups['addCC'] = $request->addCC;
            $emailsetups['addBCC'] = $request->addBCC;
            $emailsetups['isHTML'] = $request->isHTML;
            $emailsetups['Mailer'] = $request->Mailer;
            $emailsetups['send_email'] = $request->send_email;
            $emailsetups['status'] = $request->status;
            $emailsetups->save();
               
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Email setup updated."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Email setup found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emailsetups = Auth::user()->emailsetups->find($id);
        if($emailsetups) {
            $emailsetups->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Email setup deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Email setup found."], 404);
    }

    

}
