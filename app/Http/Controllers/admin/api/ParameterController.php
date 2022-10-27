<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Parameter;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ParameterController extends Controller
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
        $parameters = Parameter::with('Status')->get();
        if($parameters) {
            return response()->json(["status" => "success", "error" => false, "count" => count($parameters),"data" => $parameters], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no parameter found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no parameter found."], 404);
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
            "parameter_name" => "required|min:3|unique:parameters,parameter_name",
            "parameter_value" => "required",
            "parameter_status" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $parameters = Parameter::create([
                "parameter_name" => $request->parameter_name,
                "parameter_value" => $request->parameter_value,
                "parameter_status" => $request->parameter_status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! parameter created."], 201);
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
        $parameters = Parameter::with('Status')->where('parameters.id', '=', $id)->get();
        if($parameters) {
            return response()->json(["status" => "success", "error" => false, "count" => count($parameters),"data" => $parameters], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no parameter found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no parameter found."], 404);
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
        $parameters = Parameter::find($id);
        if($user!='' && $parameters){
            $validator = Validator::make($request->all(), [
                "parameter_name" => "required",
                "parameter_value" => "required",
                "parameter_status" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            $parameters['parameter_name'] = $request->parameter_name;
            $parameters['parameter_value'] = $request->parameter_value;
            $parameters['parameter_status'] = $request->parameter_status;
            $parameters->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! parameter updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no parameter found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parameters = Auth::user()->parameters->find($id);
        if($parameters) {
            $parameters->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! parameter deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no parameter found."], 404);
    }
}
