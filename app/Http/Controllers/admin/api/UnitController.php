<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Unit;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
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
       $units=Unit::with('statuses')->get();
        if($units) {
            return response()->json(["status" => "success", "error" => false, "count" => count($units),"data" => $units], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no unit found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no unit found."], 404);
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
            "unit_display" => "required|min:3|unique:units,unit_display",
            "status"=>"required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(406);
        }

        try {
            $unit = Unit::create([
                "unit_display" => $request->unit_display,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! unit created."], 201);
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
        //$district = Auth::user()->districts->find($id);
        $user = Auth::user();
        if($user!=''){
            $units=Unit::with('statuses')->where('units.id', '=', $id)->get();    
       
        if($units) {
            return response()->json(["status" => "success", "error" => false, "count" => count($units), "data" => $units], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no units found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no units found."], 404);
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
         $units = Unit::find($id);
        if($units!=''){
             
            $validator = Validator::make($request->all(), [
            "unit_display" => "required",
            "status"=>"required"
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors());
            }

            $units['unit_display'] = $request->unit_display;
            $units['status'] = $request->status; 
            $units->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! units updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no units found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $units = Auth::user()->units->find($id);
        if($units) {
            $units->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! units deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no units found."], 404);
    }
}
