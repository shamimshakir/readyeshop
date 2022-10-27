<?php

namespace App\Http\Controllers\admin\api;

use App\Models\PagesContent;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PagesContentController extends Controller
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
        $pagescontents = PagesContent::with('statuses')->get();
        if($pagescontents) {
            return response()->json(["status" => "success", "error" => false, "count" => count($pagescontents),"data" => $pagescontents], 200);
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
            "page_title" => "required|min:3|unique:pages_contents,page_title",
            "page_name" => "required",
            "page_content" => "required",
            "active_status" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $pagescontents = PagesContent::create([
                "page_title" => $request->page_title,
                "page_name" => $request->page_name,
                "page_content" => $request->page_content,
                "active_status" => $request->active_status,
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
        $pagescontents = PagesContent::with('statuses')->where('pages_contents.id', '=', $id)->get();
        if($pagescontents) {
            return response()->json(["status" => "success", "error" => false, "count" => count($pagescontents),"data" => $pagescontents], 200);
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
        $pagescontents = PagesContent::find($id);
        if($user!='' && $pagescontents){
            $validator = Validator::make($request->all(), [
                "page_title" => "required",
                "page_name" => "required",
                "page_content" => "required",
                "active_status" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $pagescontents['page_title'] = $request->page_title;
            $pagescontents['page_name'] = $request->page_name;
            $pagescontents['page_content'] = $request->page_content;
            $pagescontents['active_status'] = $request->active_status;
            $pagescontents->save();

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
        $pagescontents = Auth::user()->pagescontents->find($id);
        if($pagescontents) {
            $pagescontents->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! sms setup deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no sms setup found."], 404);
    }


    public function param(Request $request)
    {

        $pagescontents = PagesContent::with('statuses');

        if($request->id>0){
            $pagescontents = $pagescontents->where('pages_contents.id', '=', $request->id);
        }
        if($request->active_status>0){
            $pagescontents = $pagescontents->Where('pages_contents.active_status', '=', $request->active_status);
        }
        if($request->page_name!=''){
            $pagescontents = $pagescontents->Where('pages_contents.page_name', '=', $request->page_name);
        }
        
        $pagescontents = $pagescontents->get();
        
        if($pagescontents) {
            return response()->json(["status" => "success", "error" => false, "count" => count($pagescontents),"data" => $pagescontents], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
