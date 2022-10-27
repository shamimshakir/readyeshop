<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class VendorController extends Controller
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
       
        $vendor = Vendor::with('statuses')->get();
        if($vendor) {
            return response()->json(["status" => "success", "error" => false, "count" => count($vendor),"data" => $vendor], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no vendor found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no vendor found."], 404);
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
            "vendor_user" => "required|min:3|unique:vendors,vendor_user",
            "vendor_pass" => "required",
            "vendor_name" => "required",
            "company_name" => "required",
            "address" => "required",            
            "country" => "required",            
            "city" => "required",            
            "thana" => "required",            
            "address" => "required",            
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $vendor = Vendor::create([
                "vendor_user" => $request->vendor_user,
                "vendor_pass" => $request->vendor_pass,
                "vendor_name" => $request->vendor_name,
                "company_name" => $request->company_name,
                "address" => $request->address,               
                "city" => $request->city,
                "thana" => $request->thana,
                "postal_code" => $request->postal_code,
                "province" => $request->province,
                "country" => $request->country,
                "phone" => $request->phone,
                "email" => $request->email,
                "user_regdate" => date('Y-m-d H:i:s'),                
                "reward_point_percent" => $request->reward_point_percent,
                "reward_point_percent_customer" => $request->reward_point_percent_customer,
                "pick_loc_id" => $request->pick_loc_id,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! vendor created."], 201);           
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
       
        $vendor = Vendor::with('statuses')->where('vendors.id', '=', $id)->get();
        if($vendor) {
            return response()->json(["status" => "success", "error" => false, "count" => count($vendor),"data" => $vendor], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no vendor found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no vendor found."], 404);
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
        $vendor = Vendor::find($id);
        if($user!='' && $vendor){
            $validator = Validator::make($request->all(), [                
                "vendor_user" => "required",
                "vendor_pass" => "required",
                "vendor_name" => "required",
                "company_name" => "required",
                "address" => "required",
                "country" => "required",            
                "city" => "required",            
                "thana" => "required", 
                ]);
            
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            } 
               
            $vendor['vendor_user'] = $request->vendor_user;
            $vendor['vendor_pass'] = $request->vendor_pass;
            $vendor['vendor_name'] = $request->vendor_name;
            $vendor['company_name'] = $request->company_name;
            $vendor['address'] = $request->address;
            $vendor['city'] = $request->city;
            $vendor['thana'] = $request->thana;
            $vendor['postal_code'] = $request->postal_code;
            $vendor['province'] = $request->province;
            $vendor['country'] = $request->country;
            $vendor['phone'] = $request->phone;
            $vendor['email'] = $request->email;
            $vendor['reward_point_percent'] = $request->reward_point_percent;
            $vendor['pick_loc_id'] = $request->pick_loc_id;
            $vendor['status'] = $request->status;
            $vendor->save();
               
            return response()->json(["status" => "success", "error" => false, "message" => "Success! vendor updated."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no vendor found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Auth::user()->vendors->find($id);
        if($vendor) {
            $vendor->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! vendor deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no vendor found."], 404);
    }
}
