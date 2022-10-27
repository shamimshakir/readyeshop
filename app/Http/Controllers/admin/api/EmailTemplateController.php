<?php

namespace App\Http\Controllers\admin\api;

use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmailTemplateController extends Controller
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
       
        $emailtemplates = EmailTemplate::with('statuses')->get();
        if($emailtemplates) {
            return response()->json(["status" => "success", "error" => false, "count" => count($emailtemplates),"data" => $emailtemplates], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Eamil template found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no  Eamil template found."], 404);
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
            "short_code" => "required|min:3|unique:email_templates,short_code",
            "title" => "required",
            "body" => "required",
            "status" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $emailtemplates = EmailTemplate::create([
                "short_code" => $request->short_code,
                "title" => $request->title,
                "subject" => $request->subject,
                "body" => $request->body,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Eamil template created."], 201);
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
        $emailtemplates = EmailTemplate::with('statuses')->where('email_templates.id', '=', $id)->get();
        if($emailtemplates) {
            return response()->json(["status" => "success", "error" => false, "count" => count($emailtemplates),"data" => $emailtemplates], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Eamil template found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Eamil template found."], 404);
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
        $emailtemplates = EmailTemplate::find($id);
        if($user!='' && $emailtemplates){
            $validator = Validator::make($request->all(), [
                "short_code" => "required",
                "title" => "required",
                "body" => "required",
                "status" => "required",
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $emailtemplates['short_code'] = $request->short_code;
            $emailtemplates['title'] = $request->title;
            $emailtemplates['subject'] = $request->subject;
            $emailtemplates['body'] = $request->body;
            $emailtemplates['status'] = $request->status;
            $emailtemplates->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! Eamil template updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Eamil template found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emailtemplates = Auth::user()->emailtemplates->find($id);
        if($emailtemplates) {
            $emailtemplates->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Eamil template deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Eamil template found."], 404);
    }
}
