<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class BannerController extends Controller
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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/banner/';
        $banner = Banner::with('Status')->get();
        if($banner) {
            return response()->json(["status" => "success", "error" => false, "count" => count($banner),'url'=>$bdimageurl,"data" => $banner], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no banner found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no banner found."], 404);
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
            "title" => "required|min:3|unique:banners,title",
            "comp_url" => "required",
            "comp_name" => "required",
            "start_date" => "required",
            "end_date" => "required",
            "active_status" => "required",
           // "image" => 'required|mimes:jpeg,png,jpg,gif,svg'
            "image" => 'required'
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $image=ImageUpload($request->file('image'),'images/banner/',1920,1080);
            $banner = Banner::create([
                "title" => $request->title,
                "comp_url" => $request->comp_url,
                "comp_name" => $request->comp_name,
                "start_date" => $request->start_date,
                "end_date" => $request->end_date,
                "active_status" => $request->active_status,
                "image" => $image,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! banner created."], 201);
           
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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/banner/';
        $banner = Banner::with('Status')->where('banners.id', '=', $id)->get();
        if($banner) {
            return response()->json(["status" => "success", "error" => false, "count" => count($banner),'url'=>$bdimageurl,"data" => $banner], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no banner found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no banner found."], 404);
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
        $banner = Banner::find($id);
        if($user!='' && $banner){     
                
            $validator = Validator::make($request->all(), [                
                "title" => "required",
                "comp_url" => "required",
                "comp_name" => "required",
                "start_date" => "required",
                "end_date" => "required",
                "active_status" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            } 
                

                if($request->file('image')!=''){ 
                   $image=ImageUpload($request->file('image'),'images/banner/',1920,1080);
                   $banner['image'] = $image;
                }

                $banner['title'] = $request->title;
                $banner['comp_url'] = $request->comp_url;
                $banner['comp_name'] = $request->comp_name;
                $banner['start_date'] = $request->start_date;
                $banner['end_date'] = $request->end_date;
                $banner['active_status'] = $request->active_status;
                $banner->save(); 
               
             return response()->json(["status" => "success", "error" => false, "message" => "Success! banner updated."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no banner found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Auth::user()->banners->find($id);
        if($banner) {
            $banner->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! banner deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no banner found."], 404);
    }

    public function param(Request $request)
    {
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/banner/';
        $banner = Banner::with('Status');

        if($request->id>0){
            $banner = $banner->where('banners.id', '=', $request->id);
        }
        if($request->active_status>0){
            $banner = $banner->Where('banners.active_status', '=', $request->active_status);
        }
        
        $banner = $banner->get();
        
        if($banner) {
            return response()->json(["status" => "success", "error" => false, "count" => count($banner),'url'=>$bdimageurl,"data" => $banner], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
