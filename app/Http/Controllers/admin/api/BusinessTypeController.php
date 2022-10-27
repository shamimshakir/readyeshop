<?php

namespace App\Http\Controllers\admin\api;

use App\Models\BusinessType;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessTypeController extends Controller
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

        $businesstypes = BusinessType::All();
        if($businesstypes) {
            return response()->json(["status" => "success", "error" => false, "count" => count($businesstypes),"data" => $businesstypes], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Business Type found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Business Type found."], 404);
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
            "business_type" => "required|min:3|unique:business_types,business_type"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $businesstypes = BusinessType::create([
                "business_type" => $request->business_type,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Business Type created."], 201);
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
        $businesstypes = BusinessType::find($id);
        if($businesstypes) {
            return response()->json(["status" => "success", "error" => false,"data" => $businesstypes], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Business Type found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Business Type found."], 404);
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
        $businesstypes = BusinessType::find($id);
        if($user!='' && $businesstypes){
            $validator = Validator::make($request->all(), [
                "business_type" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            $businesstypes['business_type'] = $request->business_type;
            $businesstypes->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Business Type updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Business Type found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $businesstypes = Auth::user()->businesstypes->find($id);
        if($businesstypes) {
            $businesstypes->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Business Type deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Business Type found."], 404);
    }
}
