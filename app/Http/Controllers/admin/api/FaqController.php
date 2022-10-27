<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class FaqController extends Controller
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
       
        $faq = Faq::with('Status')->get();
        if($faq) {
            return response()->json(["status" => "success", "error" => false, "count" => count($faq),"data" => $faq], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no faq found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no faq found."], 404);
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
            "faq_question" => "required|min:3|unique:faqs,faq_question",
            "faq_answer" => "required",
            "active_status" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $faq = Faq::create([
                "faq_question" => $request->faq_question,
                "faq_answer" => $request->faq_answer,
                "active_status" => $request->active_status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! faq created."], 201);
           
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
        
        $faq = Faq::with('Status')->where('faqs.id', '=', $id)->get();
        if($faq) {
            return response()->json(["status" => "success", "error" => false, "count" => count($faq),"data" => $faq], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no faq found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no faq found."], 404);
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
        $faq = Faq::find($id);
        if($user!='' && $faq){
            $validator = Validator::make($request->all(), [                
                "faq_question" => "required",
                "faq_answer" => "required",
                "active_status" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            } 
             
                $faq['faq_question'] = $request->faq_question;
                $faq['faq_answer'] = $request->faq_answer;
                $faq['active_status'] = $request->active_status;
                $faq->save(); 
               
             return response()->json(["status" => "success", "error" => false, "message" => "Success! faq updated."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no faq found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = Auth::user()->faqs->find($id);
        if($faq) {
            $faq->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! faq deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no faq found."], 404);
    }


    public function param(Request $request)
    {

        $faq = Faq::with('Status');
        if($request->id>0){
            $faq = $faq->where('faqs.id', '=', $request->id);
        }
        if($request->active_status>0){
            $faq = $faq->Where('faqs.active_status', '=', $request->active_status);
        }
        
        $faq = $faq->get();
        
        if($faq) {
            return response()->json(["status" => "success", "error" => false, "count" => count($faq),"data" => $faq], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);        
    }
}
