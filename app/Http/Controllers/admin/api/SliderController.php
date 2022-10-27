<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Slider;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
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

        $sliders = Slider::with('statuses','sliderimages')->get();
        if($sliders) {
            return response()->json(["status" => "success", "error" => false, "count" => count($sliders),"data" => $sliders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no slider found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no slider found."], 404);
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
            "slider_name" => "required|min:3|unique:sliders,slider_name",
            "status" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $sliders = Slider::create([
                "slider_name" => $request->slider_name,
                "timestamp" => date('Y-m-d H:i:s'),
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! slider created."], 201);
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
        $sliders = Slider::with('statuses','sliderimages')->where('sliders.id', '=', $id)->get();
        if($sliders) {
            return response()->json(["status" => "success", "error" => false, "count" => count($sliders),"data" => $sliders], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no slider found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no slider found."], 404);
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
        $sliders = Slider::find($id);
        if($user!='' && $sliders){
            $validator = Validator::make($request->all(), [
                "slider_name" => "required",
                "status" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            $sliders['slider_name'] = $request->slider_name;
            $sliders['timestamp'] = date('Y-m-d H:i:s');
            $sliders['status'] = $request->status;
            $sliders->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! slider updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no slider found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sliders = Auth::user()->sliders->find($id);
        if($sliders) {
            $sliders->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! slider deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no slider found."], 404);
    }
}
