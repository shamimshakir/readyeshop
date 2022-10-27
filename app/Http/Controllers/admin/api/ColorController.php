<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Color;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Auth::user()->colors;
        //print_r($todos);
       // exit;
        return response()->json(["status" => "success", "error" => false, "count" => count($colors), "data" => $colors],200);
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
            "color_name" => "required|min:3|unique:colors,color_name",            
            "color_status" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $color = Color::create([
                "color_name" => $request->color_name,
                "other_language" => $request->other_language,
                "color_status" => $request->color_status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! color created."], 201);
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
        $color = Color::find($id);

        if($color) {
            return response()->json(["status" => "success", "error" => false, "data" => $color], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no color found."], 404);
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
        $color = Color::find($id);

        if($color) {
            $validator = Validator::make($request->all(), [
                "color_name" => "required",
                "color_status" => "required"
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $color['color_name'] = $request->color_name;
            $color['other_language'] = $request->other_language;
            $color['color_status'] = $request->color_status;

           
            $color->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! color updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no color found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $color = Auth::user()->colors->find($id);
        if($color) {
            $color->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! color deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no color found."], 404);
    }



    public function param(Request $request)
    {

        $color = Color::with('statuses');

        if($request->id>0){
            $color = $color->where('colors.id', '=', $request->id);
        }
        if($request->color_status>0){
            $color = $color->Where('colors.color_status', '=', $request->color_status);
        }
        if($request->color_name!=''){
            $color = $color->Where('colors.color_name', '=', $request->color_name);
        }
        if($request->other_language!=''){
            $color = $color->Where('colors.other_language', '=', $request->other_language);
        }
        $color = $color->get();
        
        if($color) {
            return response()->json(["status" => "success", "error" => false, "count" => count($color),"data" => $color], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
