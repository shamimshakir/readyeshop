<?php

namespace App\Http\Controllers\admin\api;

use App\Models\UserGuide;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserGuideController extends Controller
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
        $userguides = UserGuide::All();
        if($userguides) {
            return response()->json(["status" => "success", "error" => false, "count" => count($userguides),"data" => $userguides], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no UserGuide found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no UserGuide found."], 404);
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
            "question" => "required|min:3|unique:user_guides,question",
            "video" => "required",
            "menu_name" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $userguides = UserGuide::create([
                "question" => $request->question,
                "video" => $request->video,
                "menu_name" => $request->menu_name,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! UserGuide created."], 201);
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
        $userguides = UserGuide::where('user_guides.id', '=', $id)->get();
        //$userguides = UserGuide::find($id)->get();
        if($userguides) {
            return response()->json(["status" => "success", "error" => false,"data" => $userguides], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no UserGuide found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no UserGuide found."], 404);
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
        $userguides = UserGuide::find($id);
        if($user!='' && $userguides){
            $validator = Validator::make($request->all(), [
                "question" => "required",
                "video" => "required",
                "menu_name" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $userguides['question'] = $request->question;
            $userguides['video'] = $request->video;
            $userguides['menu_name'] = $request->menu_name;
            $userguides->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! UserGuide updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no UserGuide found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $userguides = Auth::user()->userguides->find($id);
        if($userguides) {
            $userguides->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! UserGuide deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no UserGuide found."], 404);
    }

    public function param(Request $request){        
       $user = Auth::user();
       if($user!=''){
        $userguides = UserGuide::select('*');
        if($request->menu_name>0){
            $userguides = $userguides->where('user_guides.menu_name', '=', $request->menu_name);
        }
        $userguides = $userguides->get();
        if($userguides) {
            return response()->json(["status" => "success", "error" => false,"data" => $userguides], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no UserGuide found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no UserGuide found."], 404);
        
    }
}
