<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Theme;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ThemeController extends Controller
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

        $themes = Theme::with('statuses')->get();
        if($themes) {
            return response()->json(["status" => "success", "error" => false, "count" => count($themes),"data" => $themes], 200);
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
            "theme_name" => "required|min:3|unique:themes,theme_name",
            "status" => "required",
            "edit_status" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $smssetups = Theme::create([
                "theme_name" => $request->theme_name,
                "status" => $request->status,
                "edit_status" => $request->edit_status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Themes created."], 201);
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

        $themes = Theme::with('statuses')->where('themes.id', '=', $id)->get();
        if($themes) {
            return response()->json(["status" => "success", "error" => false, "count" => count($themes),"data" => $themes], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Theme found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Theme found."], 404);
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
        $themes = Theme::find($id);
        if($user!='' && $themes){
            $validator = Validator::make($request->all(), [
                "theme_name" => "required",
                "status" => "required",
                "edit_status" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $themes['theme_name'] = $request->theme_name;
            $themes['status'] = $request->status;
            $themes['edit_status'] = $request->edit_status;
            $themes->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! Theme updated."], 201);

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
        $themes = Auth::user()->themes->find($id);
        if($themes) {
            $themes->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! themes deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no themes found."], 404);
    }
}
