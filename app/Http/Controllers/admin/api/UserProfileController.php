<?php

namespace App\Http\Controllers\admin\api;

use App\Models\UserProfile;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
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
        $userprofiles = UserProfile::All();
        if($userprofiles) {
            return response()->json(["status" => "success", "error" => false, "count" => count($userprofiles),"data" => $userprofiles], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no UserProfile found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no UserProfile found."], 404);
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
            "profile_name" => "required|min:3|unique:user_profiles,profile_name"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $userprofiles = UserProfile::create([
                "profile_name" => $request->profile_name,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! User Profile created."], 201);
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
        $userprofiles = UserProfile::find($id);
        if($userprofiles) {
            return response()->json(["status" => "success", "error" => false, "data" => $userprofiles], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no User Profile found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no User Profile found."], 404);
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
        $userprofiles = UserProfile::find($id);
        if($user!='' && $userprofiles){
            $validator = Validator::make($request->all(), [
                "profile_name" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $userprofiles['profile_name'] = $request->profile_name;
            $userprofiles->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! UserProfile updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no UserProfile found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $userprofiles = Auth::user()->userprofiles->find($id);
        if($userprofiles) {
            $userprofiles->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! UserProfile deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no UserProfile found."], 404);
    }
}
