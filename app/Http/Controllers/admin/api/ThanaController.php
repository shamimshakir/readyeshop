<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Thana;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ThanaController extends Controller
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
       $thana=Thana::select("thanas.id", 
                            "thanas.name",
                            "thanas.district_id",
                            "thanas.coverage",
                            "thanas.drop_point",
                            "districts.location as district_name"
                        )
                        ->join("districts", "districts.id", "=", "thanas.district_id")
                        ->get();      
        if($thana) {
            return response()->json(["status" => "success", "error" => false, "count" => count($thana),"data" => $thana], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no thana found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no thana found."], 404);
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
            "name" => "required|min:3|unique:thanas,name",
            "district_id" => "required",
            "coverage"=>"required" 
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(406);
        }

        try {
            $thana = Thana::create([
                "name" => $request->name,
                "district_id" => $request->district_id,
                "coverage" => $request->coverage,
                "user_id " => Auth::user()->id,
                "drop_point" => $request->drop_point
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! countries created."], 201);
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
            $thana=Thana::select("thanas.id", 
                            "thanas.name",
                            "thanas.district_id",
                            "thanas.coverage",
                            "thanas.drop_point",
                            "districts.location as district_name"
                        )
                        ->join("districts", "districts.id", "=", "thanas.district_id")
                        ->where('thanas.id', '=', $id)
                        ->get();
        

        if($thana) {
            return response()->json(["status" => "success", "error" => false, "count" => count($thana), "data" => $thana], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no district found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no district found."], 404);
    }
    public function showByDistrict($id)
    {
        $thana=Thana::select("thanas.id", 
                            "thanas.name",
                            "thanas.district_id",
                            "thanas.coverage",
                            "thanas.drop_point",
                            "districts.location as district_name"
                        )
                        ->join("districts", "districts.id", "=", "thanas.district_id")
                        ->where('thanas.district_id', '=', $id)
                        ->get();

       if($thana) {
           return response()->json(["status" => "success", "error" => false, "count" => count($thana), "data" => $thana], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no district found."], 404);
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
        $thana = Thana::find($id);
        
        
        if($thana) {
            $validator = Validator::make($request->all(), [                
                "name" => "required",
                "district_id" => "required",
                "coverage"=> "required",
                "drop_point"=> "required"
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(406);
            }

            $thana['name'] = $request->name;
            $thana['district_id'] = $request->district_id;    
            $thana['coverage'] = $request->coverage;    
            $thana['drop_point'] = $request->drop_point;    
                    

            $thana->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! thana updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no thana found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $thana = Auth::user()->thanas->find($id);
        if($thana) {
            $thana->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! thana deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no thana found."], 404);
    }

    public function param(Request $request)
    {
        //$district = Auth::user()->districts->find($id);
        
            $thana=Thana::select("thanas.id", 
                            "thanas.name",
                            "thanas.district_id",
                            "thanas.coverage",
                            "thanas.drop_point",
                            "districts.location as district_name"
                        )
                        ->join("districts", "districts.id", "=", "thanas.district_id");
            if($request->id>0){
                $thana = $thana->where('thanas.id', '=', $request->id);
            }
            if($request->district>0){
                $thana = $thana->where('thanas.district_id', '=', $request->district);
            }
            $thana = $thana->get();
        

        if($thana) {
            return response()->json(["status" => "success", "error" => false, "count" => count($thana), "data" => $thana], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no district found."], 404);
    
    }


}
