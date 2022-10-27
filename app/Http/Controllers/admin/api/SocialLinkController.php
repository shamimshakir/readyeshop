<?php

namespace App\Http\Controllers\admin\api;

use App\Models\SocialLink;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SocialLinkController extends Controller
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
       $social_link=SocialLink::select("social_links.id", 
                            "social_links.social_name",
                            "social_links.url",
                            "social_links.icon",
                            "social_links.active_status",
                            "statuses.stat_desc as ststus_name",
                            "social_links.created_at",
                            "social_links.updated_at"
                        ) 
                        ->join("statuses", "statuses.id", "=", "social_links.active_status")
                        ->get();      
        if($social_link) {
        
            return response()->json(["status" => "success", "error" => false, "count" => count($social_link),"data" => $social_link], 200);
        
            
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no social links found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no social links found."], 404);
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
            "social_name" => "required|min:3|unique:social_links,social_name",
            "url" => "required",
            "icon" => "required",
            "active_status" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $social_link = SocialLink::create([
                "social_name" => $request->social_name,
                "url" => $request->url,
                "icon" => $request->icon,
                "active_status" => $request->active_status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! social link created."], 201);
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
            $social_link=SocialLink::select("social_links.id", 
                            "social_links.social_name",
                            "social_links.url",
                            "social_links.icon",
                            "social_links.active_status",
                            "statuses.stat_desc as ststus_name",
                            "social_links.created_at",
                            "social_links.updated_at"
                        ) 
                        ->join("statuses", "statuses.id", "=", "social_links.active_status")
                        ->where('social_links.id', '=', $id)
                        ->get();    
       
        if($social_link) {
            return response()->json(["status" => "success", "error" => false, "count" => count($social_link), "data" => $social_link], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no social link found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no social link found."], 404);
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
        $social_links = SocialLink::find($id);

        if($social_links) {
            $validator = Validator::make($request->all(), [
            "social_name" => "required",
            "url" => "required",
            "icon" => "required",
            "active_status" => "required", 
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $social_links['social_name'] = $request->social_name;
            $social_links['url'] = $request->url;
            $social_links['icon'] = $request->icon;
            $social_links['active_status'] = $request->active_status;

           
            $social_links->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! social links updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no social links found."], 404);
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

        $social = SocialLink::with('statuses');

        if($request->id>0){
            $social = $social->where('social_links.id', '=', $request->id);
        }
        if($request->active_status>0){
            $social = $social->Where('social_links.active_status', '=', $request->active_status);
        }
        if($request->social_name!=''){
            $social = $social->Where('social_links.social_name', '=', $request->social_name);
        }
        if($request->url!=''){
            $social = $social->Where('social_links.url', '=', $request->url);
        }
        $social = $social->get();
        
        if($social) {
            return response()->json(["status" => "success", "error" => false, "count" => count($social),"data" => $social], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
