<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
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
       $brand=Brand::select("brands.id", 
                            "brands.brand_display",
                            "brands.other_band_name",
                            "brands.status",
                            "statuses.stat_desc as ststus_name",
                            "brands.created_at",
                            "brands.updated_at"
                        )
                        ->join("statuses", "statuses.id", "=", "brands.status")
                        ->get();      
        if($brand) {
            return response()->json(["status" => "success", "error" => false, "count" => count($brand),"data" => $brand], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no brand found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no brand found."], 404);
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
            "brand_display" => "required|min:3|unique:brands,brand_display",
           
            "status"=>"required" 
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(406);
        }

        try {
            $brand = Brand::create([
                "brand_display" => $request->brand_display,
                "other_band_name" => $request->other_band_name,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! brand created."], 201);
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
            $brand=Brand::select("brands.id", 
                            "brands.brand_display",
                            "brands.other_band_name",
                            "brands.status",
                            "statuses.stat_desc as ststus_name",
                            "brands.created_at",
                            "brands.updated_at"
                        )
                        ->join("statuses", "statuses.id", "=", "brands.status")
                        ->where('brands.id', '=', $id)
                        ->get();    
       
        if($brand) {
            return response()->json(["status" => "success", "error" => false, "count" => count($brand), "data" => $brand], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no brand found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no brand found."], 404);
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
        $brand = Brand::find($id);

        if($brand) {
            $validator = Validator::make($request->all(), [                
                "brand_display" => "required",
                
                "status"=>"required"
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(406);
            }

            $brand['brand_display'] = $request->brand_display;
            $brand['other_band_name'] = $request->other_band_name;    
            $brand['status'] = $request->status;    
                    

            $brand->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! brand updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no brand found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Auth::user()->brands->find($id);
        if($brand) {
            $brand->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! brand deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no brand found."], 404);
    }

    public function param(Request $request)
    {

        $brands = Brand::with('statuses');

        if($request->id>0){
            $brands = $brands->where('brands.id', '=', $request->id);
        }
        if($request->status>0){
            $size = $brands->Where('brands.status', '=', $request->status);
        }
        if($request->brand_display!=''){
            $brands = $brands->Where('brands.brand_display', '=', $request->brand_display);
        }
        if($request->other_band_name!=''){
            $brands = $brands->Where('brands.other_band_name', '=', $request->other_band_name);
        }
        $brands = $brands->get();
        
        if($brands) {
            return response()->json(["status" => "success", "error" => false, "count" => count($brands),"data" => $brands], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
