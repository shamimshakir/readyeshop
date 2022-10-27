<?php

namespace App\Http\Controllers;

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
        $parameters = Parameter::with('Status')->get();
        if($parameters) {
            return response()->json(["status" => "success", "error" => false, "count" => count($parameters),"data" => $parameters], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no parameter found."], 404);
    }

   
}
