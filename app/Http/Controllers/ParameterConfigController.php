<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ParameterConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = Parameter::with('Status')->get();
        if($parameters) {
            return response()->json(["status" => "success", "error" => false, "count" => count($parameters),"data" => $parameters], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no parameter found."], 404);
    }

    public function param(Request $request)
    {
        $parameters = Parameter::with('Status');

        if($request->id>0){
            $parameters = $parameters->where('parameters.id', '=', $request->id);
        }
        if($request->parameter_name!=''){
            $parameters = $parameters->Where('parameters.parameter_name', '=', $request->parameter_name);
        }
        if($request->parameter_status>0){
            $parameters = $parameters->Where('parameters.parameter_status', '=', $request->parameter_status);
        }
        if($request->parameter_value!=''){
            $parameters = $parameters->Where('parameters.parameter_value', '=', $request->parameter_value);
        }
        $parameters = $parameters->get();
        
        if($parameters) {
            return response()->json(["status" => "success", "error" => false, "count" => count($parameters),"data" => $parameters], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }

   
}
