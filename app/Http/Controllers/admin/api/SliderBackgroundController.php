<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\SliderBackground;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class SliderBackgroundController extends Controller
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
        $sliderbackgroundurl= url($_SERVER['SERVER_NAME']).'/images/sliderbackground/';
        $sliderbackgrounds = SliderBackground::with('statuses')->get();
        if($sliderbackgrounds) {
            return response()->json(["status" => "success", "error" => false, 'url'=>$sliderbackgroundurl, "count" => count($sliderbackgrounds),"data" => $sliderbackgrounds], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Slider Background found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Slider Background found."], 404);
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
            "bg_type" => "required",            
            "active_status" => "required",
            "image" => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $image='';
            if($request->file('image')!=''){
                $image=ImageUpload($request->file('image'),'images/sliderbackground/',1920,718);
            }
            $sliderbackgrounds = SliderBackground::create([
                "bg_type" => $request->bg_type,
                "additional_text" =>($request->additional_text==null) ? '' : $request->additional_text,
                "second_text" => ($request->second_text==null) ? '' : $request->second_text,
                "main_text" => ($request->main_text==null) ? '' : $request->main_text,
                "active_status" => $request->active_status,
                "image" => $image,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Slider Background created."], 201);
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
         $SliderBackgroundurl= url($_SERVER['SERVER_NAME']).'/images/sliderbackground/';
        $sliderbackgrounds = SliderBackground::with('statuses')->where('slider_backgrounds.id', '=', $id)->get();
        if($sliderbackgrounds) {
            return response()->json(["status" => "success", "error" => false,  'url'=>$SliderBackgroundurl, "count" => count($sliderbackgrounds),"data" => $sliderbackgrounds], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no SliderBackground found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no SliderBackground found."], 404);
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
        $sliderbackgrounds = SliderBackground::find($id);
        if($user!='' && $sliderbackgrounds){
            $validator = Validator::make($request->all(), [
                "bg_type" => "required",               
                "active_status" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $images='';
            if($request->file('image')!=''){
                $image=ImageUpload($request->file('image'),'images/sliderbackground/',1920,718);
                $sliderbackgrounds['image'] = $image;
            }
            $sliderbackgrounds['bg_type'] = $request->bg_type;  
            $sliderbackgrounds['additional_text'] =($request->additional_text==null) ? '' : $request->additional_text;
            $sliderbackgrounds['main_text'] =($request->main_text==null) ? '' : $request->main_text;
            $sliderbackgrounds['second_text'] =($request->second_text==null) ? '' : $request->second_text;
            $sliderbackgrounds['active_status'] = $request->active_status;
            $sliderbackgrounds->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Slider Background updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Slider Background found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sliderbackgrounds = Auth::user()->sliderbackgrounds->find($id);
        if($sliderbackgrounds) {
            $sliderbackgrounds->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Slider Background deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Slider Background found."], 404);
    }

    public function param(Request $request)
    {

        $sliderimageurl= url($_SERVER['SERVER_NAME']).'/images/sliderbackground/';
        $sliderbackgrounds = SliderBackground::with('statuses');

        if($request->id>0){
            $sliderbackgrounds = $sliderbackgrounds->where('slider_backgrounds.id', '=', $request->id);
        }
        if($request->active_status>0){
            $sliderbackgrounds = $sliderbackgrounds->Where('slider_backgrounds.active_status', '=', $request->active_status);
        }
        if($request->bg_type>0){
            $sliderbackgrounds = $sliderbackgrounds->Where('slider_backgrounds.bg_type', '=', $request->bg_type);
        }
        
        $sliderbackgrounds = $sliderbackgrounds->get();
        
        if($sliderbackgrounds) {
            return response()->json(["status" => "success", "error" => false, 'url'=>$sliderimageurl, "count" => count($sliderbackgrounds),"data" => $sliderbackgrounds], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
