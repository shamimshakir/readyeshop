<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\SliderImage;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class SliderImageController extends Controller
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
        $sliderimageurl= url($_SERVER['SERVER_NAME']).'/images/slider/';
        $sliderimages = SliderImage::with('statuses','sliders')->get();
        if($sliderimages) {
            return response()->json(["status" => "success", "error" => false, 'url'=>$sliderimageurl, "count" => count($sliderimages),"data" => $sliderimages], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no SliderImage found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no SliderImage found."], 404);
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
            "slider_id" => "required",
            "act_status" => "required",
            "bg_img" => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $bg_img='';
            if($request->file('bg_img')!=''){
                $bg_img=ImageUpload($request->file('bg_img'),'images/slider/',1920,718);
            }
            $sliderimages = SliderImage::create([
                "slider_id" => $request->slider_id,
                "bg_img" => $bg_img,
                "url" => $request->url,
                "main_text" => $request->main_text,
                "title_text" => $request->title_text,
                "alt_text" => $request->alt_text,
                "act_status" => $request->act_status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Slider created."], 201);
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
         $sliderimageurl= url($_SERVER['SERVER_NAME']).'/images/slider/';
        $sliderimages = SliderImage::with('statuses','sliders')->where('slider_images.id', '=', $id)->get();
        if($sliderimages) {
            return response()->json(["status" => "success", "error" => false,  'url'=>$sliderimageurl, "count" => count($sliderimages),"data" => $sliderimages], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no SliderImage found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no SliderImage found."], 404);
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
        $sliderimages = SliderImage::find($id);
        if($user!='' && $sliderimages){
            $validator = Validator::make($request->all(), [
                "slider_id" => "required",
                "act_status" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $bg_img='';
            if($request->file('bg_img')!=''){
                $bg_img=ImageUpload($request->file('bg_img'),'images/slider/',1920,718);
                $sliderimages['bg_img'] = $bg_img;
            }
            $sliderimages['slider_id'] = $request->slider_id;
            
            $sliderimages['url'] = $request->url;
            $sliderimages['main_text'] = $request->main_text;
            $sliderimages['title_text'] = $request->title_text;
            $sliderimages['alt_text'] = $request->alt_text;
            $sliderimages['act_status'] = $request->act_status;
            $sliderimages->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! SliderImage updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no SliderImage found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sliderimages = Auth::user()->sliderimages->find($id);
        if($sliderimages) {
            $sliderimages->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! SliderImage deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no SliderImage found."], 404);
    }


    public function param(Request $request)
    {

        $sliderimageurl= url($_SERVER['SERVER_NAME']).'/images/slider/';
        $sliderimages = SliderImage::with('statuses','sliders');

        if($request->slider_id>0){
            $sliderimages = $sliderimages->where('slider_images.slider_id', '=', $request->slider_id);
        }
        if($request->act_status>0){
            $sliderimages = $sliderimages->Where('slider_images.act_status', '=', $request->act_status);
        }
        
        $sliderimages = $sliderimages->get();
        
        if($sliderimages) {
            return response()->json(["status" => "success", "error" => false, 'url'=>$sliderimageurl, "count" => count($sliderimages),"data" => $sliderimages], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
