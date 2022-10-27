<?php

namespace App\Http\Controllers\admin\api;

use App\Models\ProductTag;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductTagController extends Controller
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
        $producttags = ProductTag::All();
        if($producttags) {
            return response()->json(["status" => "success", "error" => false, "count" => count($producttags),"data" => $producttags], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ProductTag found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ProductTag found."], 404);
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
            "location_detail" => "required",
            "tag_name" => "required",
            "tag_label" => "required",
            "status" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $producttags = ProductTag::create([
                "tag_location" => $request->tag_location,
                "location_detail" => $request->location_detail,
                "tag_name" => $request->tag_name,
                "tag_label" => $request->tag_label,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! ProductTag created."], 201);
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
        $producttags = ProductTag::find($id);
        if($producttags) {
            return response()->json(["status" => "success", "error" => false, "data" => $producttags], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ProductTag found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ProductTag found."], 404);
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
        $producttags = ProductTag::find($id);
        if($user!='' && $producttags){
            $validator = Validator::make($request->all(), [
                
                "location_detail" => "required",
                "tag_name" => "required",
                "tag_label" => "required",
                "status" => "required",
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $producttags['tag_location'] = $request->tag_location;
            $producttags['location_detail'] = $request->location_detail;
            $producttags['tag_name'] = $request->tag_name;
            $producttags['tag_label'] = $request->tag_label;
            $producttags['status'] = $request->status;
            $producttags->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! ProductTag updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no ProductTag found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $producttags = Auth::user()->ProductTag->find($id);
        if($producttags) {
            $producttags->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! ProductTag deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no ProductTag found."], 404);
    }


    public function param(Request $request)
    {

        $producttags = ProductTag::select('*');
        
        if($request->id>0){
            $producttags = $producttags->Where('product_tags.id', '=', $request->id);
        }
        if($request->tag_location!=''){
            $producttags = $producttags->Where('product_tags.tag_location', '=', $request->tag_location);
        }
        if($request->tag_name!=''){
            $producttags = $producttags->Where('product_tags.tag_name', '=', $request->tag_name);
        }
        if($request->tag_label!=''){
            $producttags = $producttags->Where('product_tags.tag_label', '=', $request->tag_label);
        }
        $producttags = $producttags->get();
        
        if($producttags) {
            return response()->json(["status" => "success", "error" => false, "count" => count($producttags),"data" => $producttags], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
