<?php

namespace App\Http\Controllers\admin\api;

use App\Models\District;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller
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
       $district=District::select("districts.id", 
                            "districts.location",
                            "districts.country_id",
                            "districts.price",
                            "countries.name as country_name",
                            "districts.created_at",
                            "districts.updated_at"
                        )
                        ->join("countries", "countries.id", "=", "districts.country_id")
                        ->get();      
        if($district) {
            return response()->json(["status" => "success", "error" => false, "count" => count($district),"data" => $district], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no district found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no district found."], 404);
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
            "location" => "required|min:3|unique:districts,location",
            "country_id" => "required",
            "price"=>"required" 
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(406);
        }

        try {
            $district = District::create([
                "location" => $request->location,
                "country_id" => $request->country_id,
                "price" => $request->price,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! district created."], 201);
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
        $district=District::select("districts.id", 
                            "districts.location",
                            "districts.country_id",
                            "districts.price",
                            "countries.name as country_name",
                            "districts.created_at",
                            "districts.updated_at"
                        )
                        ->join("countries", "countries.id", "=", "districts.country_id")
                        ->where('districts.id', '=', $id)
                        ->get();   

        if($district) {
            return response()->json(["status" => "success", "error" => false, "count" => count($district), "data" => $district], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no district found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no district found."], 404);
    }
    public function showByCountry($country_id)
    {
        $district=District::select("districts.id", 
                            "districts.location",
                            "districts.country_id",
                            "districts.price",
                            "countries.name as country_name",
                            "districts.created_at",
                            "districts.updated_at"
                        )
                        ->join("countries", "countries.id", "=", "districts.country_id")
                        ->where('districts.country_id', '=', $country_id)
                        ->get();   

       if($district) {
           return response()->json(["status" => "success", "error" => false, "count" => count($district), "data" => $district], 200);
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
        $district = District::find($id);

        if($district) {
            $validator = Validator::make($request->all(), [                
                "location" => "required",
                "country_id" => "required",
                "price"=> "required"
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(406);
            }

            $district['location'] = $request->location;
            $district['country_id'] = $request->country_id;    
            $district['price'] = $request->price;    
                    

            $district->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! district updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no district found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $district = Auth::user()->districts->find($id);
        if($district) {
            $district->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! district deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no district found."], 404);
    }

    public function param(Request $request)
    {
        
        $district=District::select("districts.id", 
                            "districts.location",
                            "districts.country_id",
                            "districts.price",
                            "countries.name as country_name"
                        )
                        ->join("countries", "countries.id", "=", "districts.country_id");
            if($request->id>0){
                $district = $district->where('districts.id', '=', $request->id);
            }
            if($request->country>0){
                $district = $district->where('districts.country_id', '=', $request->country);
            }
            $district = $district->get();

        if($district) {
            return response()->json(["status" => "success", "error" => false, "count" => count($district), "data" => $district], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no district found."], 404);
    
    }
    public function get_shipping_cost(Request $request)
    {
         $validator = Validator::make($request->all(), [                
                "id" => "required"
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(406);
            }

        $district=District::select("districts.price");
            if($request->id>0){
                $district = $district->where('districts.id', '=', $request->id);
            }
            $district = $district->get();

        if($district) {
            return response()->json(["status" => "success", "error" => false, "count" => count($district), "data" => $district], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Shipping cost found."], 404);
    
    }

}
