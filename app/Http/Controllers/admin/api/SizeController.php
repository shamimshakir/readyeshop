<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Size;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Auth::user()->sizes;
        //print_r($todos);
       // exit;
        return response()->json(["status" => "success", "error" => false, "count" => count($sizes), "data" => $sizes],200);
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
            "size_display" => "required|min:3|unique:sizes,size_display",
            "status" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(406);
        }

        try {
            $sizes = Size::create([
                "size_display" => $request->size_display,
                "size_type" => $request->size_type,
                "size_remarks" => $request->size_remarks,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! size created."], 201);
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
        $sizes = Size::find($id);

        if($sizes) {
            return response()->json(["status" => "success", "error" => false, "data" => $sizes], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sizes found."], 404);
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
        $size = Size::find($id);

        if($size) {
            $validator = Validator::make($request->all(), [
                "size_display" => "required",
                "status" => "required"
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(406);
            }

            $size['size_display'] = $request->size_display;
            $size['status'] = $request->status;
            $size['size_type'] = $request->size_type;
            $size['size_remarks'] = $request->size_remarks;
            $size->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! size updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no size found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size = Auth::user()->sizes->find($id);
        if($size) {
            $size->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! size deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no size found."], 404);
    }


    public function param(Request $request)
    {

        $size = Size::with('statuses');

        if($request->id>0){
            $size = $size->where('sizes.id', '=', $request->id);
        }
        if($request->status>0){
            $size = $size->Where('sizes.status', '=', $request->status);
        }
        if($request->size_type!=''){
            $size = $size->Where('sizes.size_type', '=', $request->size_type);
        }
        if($request->size_display!=''){
            $size = $size->Where('sizes.size_display', '=', $request->size_display);
        }
        $size = $size->get();
        
        if($size) {
            return response()->json(["status" => "success", "error" => false, "count" => count($size),"data" => $size], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
