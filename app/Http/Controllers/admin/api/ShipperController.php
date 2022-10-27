<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\Shipper;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class ShipperController extends Controller
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
       
        $shipper = Shipper::with('statuses')->get();
        if($shipper) {
            return response()->json(["status" => "success", "error" => false, "count" => count($shipper),"data" => $shipper], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no shipper found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no shipper found."], 404);
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
            "sp_name" => "required|min:3|unique:shippers,sp_name",
            "sp_sddress" => "required",
            "sp_mobile" => "required",
            "sp_email" => "required",
                      
            "status" => "required",            
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $shipper = Shipper::create([
                "sp_name" => $request->sp_name,
                "sp_sddress" => $request->sp_sddress,
                "sp_mobile" => $request->sp_mobile,
                "sp_email" => $request->sp_email,
                "sp_company" => $request->sp_company,               
                "sp_contact_person" => $request->sp_contact_person,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Shipper created."], 201);           
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
       
        $shipper = Shipper::with('statuses')->where('shippers.id', '=', $id)->get();
        if($shipper) {
            return response()->json(["status" => "success", "error" => false, "count" => count($shipper),"data" => $shipper], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no shipper found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no shipper found."], 404);
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
        $shipper = Shipper::find($id);
        if($user!='' && $shipper){
            $validator = Validator::make($request->all(), [                
                "sp_name" => "required",
                "sp_sddress" => "required",
                "sp_mobile" => "required",
                "sp_email" => "required",
                       
                "status" => "required",
                ]);            
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }                
            $shipper['sp_name'] = $request->sp_name;
            $shipper['sp_sddress'] = $request->sp_sddress;            
            $shipper['sp_mobile'] = $request->sp_mobile;
            $shipper['sp_email'] = $request->sp_email;
            $shipper['sp_company'] = $request->sp_company;
            $shipper['sp_contact_person'] = $request->sp_contact_person;
            $shipper['status'] = $request->status;
            $shipper->save();               
            return response()->json(["status" => "success", "error" => false, "message" => "Success! shipper updated."], 201);                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no shipper found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipper = Auth::user()->shippers->find($id);
        if($shipper) {
            $shipper->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! shipper deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no shipper found."], 404);
    }
}
