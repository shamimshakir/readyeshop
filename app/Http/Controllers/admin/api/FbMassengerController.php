<?php

namespace App\Http\Controllers\admin\api;

use App\Models\FbMassenger;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FbMassengerController extends Controller
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
        $fbmassengers = FbMassenger::with('statuses')->get();
        if($fbmassengers) {
            return response()->json(["status" => "success", "error" => false, "count" => count($fbmassengers),"data" => $fbmassengers], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no FbMassenger found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no FbMassenger found."], 404);
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
            "name" => "required",
            "command" => "required",
            "status" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $fbmassengers = FbMassenger::create([
                "name" => $request->name,
                "command" => $request->command,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! FbMassenger created."], 201);
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
        $fbmassengers = FbMassenger::with('statuses')->where('fb_massengers.id', '=', $id)->get();
        if($fbmassengers) {
            return response()->json(["status" => "success", "error" => false, "count" => count($fbmassengers),"data" => $fbmassengers], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no FbMassenger found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no FbMassenger found."], 404);
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
        $fbmassengers = FbMassenger::find($id);
        if($user!='' && $fbmassengers){
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "command" => "required",
                "status" => "required",
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $fbmassengers['name'] = $request->name;
            $fbmassengers['command'] = $request->command;
            $fbmassengers['status'] = $request->status;
            $fbmassengers->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! FbMassenger updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no FbMassenger found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $fbmassengers = Auth::user()->fbmassengers->find($id);
        if($fbmassengers) {
            $fbmassengers->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! FbMassenger deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no FbMassenger found."], 404);
    }
    
    
    public function param(Request $request)
    {        
        $fbmassengers = FbMassenger::select("command");
        if($request->name!=''){
            $fbmassengers = $fbmassengers->where('fb_massengers.name', '=', $request->name);
        }
        if($request->status>0){
            $fbmassengers = $fbmassengers->Where('fb_massengers.status', '=', $request->status);
        }
        $fbmassengers = $fbmassengers->get(); 
        $tt=null;
        foreach ($fbmassengers as $index => $da) {  
                $tt = $da->command;
        }
        if($fbmassengers) {
            return  $tt;
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no FbMassenger found."], 404);        
    }
}
