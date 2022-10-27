<?php

namespace App\Http\Controllers\admin\api;

use App\Models\PickupLocation;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PickupLocationController extends Controller
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
        $pickuplocations = PickupLocation::with('statuses')->get();
        if($pickuplocations) {
            return response()->json(["status" => "success", "error" => false, "count" => count($pickuplocations),"data" => $pickuplocations], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no pickup locations found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no pickup locations found."], 404);
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
            "location" => "required",
            "address" => "required",
            "city" => "required",
            "loc_status" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $pickuplocations = PickupLocation::create([
                "location" => $request->location,
                "address" => $request->address,
                "city" => $request->city,
                "loc_status" => $request->loc_status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! pickup locations created."], 201);
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

        $pickuplocations = PickupLocation::with('statuses')->where('pickup_locations.id', '=', $id)->get();
        if($pickuplocations) {
            return response()->json(["status" => "success", "error" => false, "count" => count($pickuplocations),"data" => $pickuplocations], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no pickup locations found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no pickup locations found."], 404);
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
        $pickuplocations = PickupLocation::find($id);
        if($user!='' && $pickuplocations){
            $validator = Validator::make($request->all(), [
                "location" => "required",
                "address" => "required",
                "city" => "required",
                "loc_status" => "required",
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $pickuplocations['location'] = $request->location;
            $pickuplocations['address'] = $request->address;
            $pickuplocations['city'] = $request->city;
            $pickuplocations['loc_status'] = $request->loc_status;
            $pickuplocations->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! pickup locations updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no pickup locations found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pickuplocations = Auth::user()->pickuplocations->find($id);
        if($pickuplocations) {
            $pickuplocations->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! pickup locations deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no pickup locations found."], 404);
    }
}
