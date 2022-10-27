<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\SponsorAd;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;


class SponsorAdController extends Controller
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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/sponsorad/';
        $SponsorAd = SponsorAd::with('statuses')->get();
        if($SponsorAd) {
            return response()->json(["status" => "success", "error" => false, "count" => count($SponsorAd),'url'=>$bdimageurl,"data" => $SponsorAd], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no SponsorAd found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no SponsorAd found."], 404);
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
            "name" => "required|min:3|unique:sponsor_ads,name",
            "link" => "required",
            "act_status" => "required",
            "logo" => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $image=ImageUpload($request->file('logo'),'images/sponsorad/',180,60);
            $SponsorAd = SponsorAd::create([
                "name" => $request->name,
                "link" => $request->link,
                "act_status" => $request->act_status,
                "logo" => $image,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! SponsorAd created."], 201);

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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/sponsorad/';
        $SponsorAd = SponsorAd::with('statuses')->where('sponsor_ads.id', '=', $id)->get();
        if($SponsorAd) {
            return response()->json(["status" => "success", "error" => false, "count" => count($SponsorAd),'url'=>$bdimageurl,"data" => $SponsorAd], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no SponsorAd found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no SponsorAd found."], 404);
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
        $SponsorAd = SponsorAd::find($id);
        if($user!='' && $SponsorAd){
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "link" => "required",
                "act_status" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

                if($request->file('logo')!=''){
                   $image=ImageUpload($request->file('logo'),'images/sponsorad/',180,60);
                   $SponsorAd['logo'] = $image;
                }

                $SponsorAd['name'] = $request->name;
                $SponsorAd['link'] = $request->link;
                $SponsorAd['act_status'] = $request->act_status;
                $SponsorAd->save();

             return response()->json(["status" => "success", "error" => false, "message" => "Success! SponsorAd updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no SponsorAd found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $SponsorAd = Auth::user()->sponsorads->find($id);
        if($SponsorAd) {
            $SponsorAd->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! SponsorAd deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no SponsorAd found."], 404);
    }


    public function param(Request $request)
    {
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/sponsorad/';
        $SponsorAd = SponsorAd::with('statuses');

        if($request->id>0){
            $SponsorAd = $SponsorAd->where('sponsor_ads.id', '=', $request->id);
        }
        if($request->act_status>0){
            $SponsorAd = $SponsorAd->Where('sponsor_ads.act_status', '=', $request->act_status);
        }
        if($request->name!=''){
            $SponsorAd = $SponsorAd->Where('sponsor_ads.name', '=', $request->name);
        }
        
        $SponsorAd = $SponsorAd->get();
        
        if($SponsorAd) {
            return response()->json(["status" => "success", "error" => false, "count" => count($SponsorAd),'url'=>$bdimageurl,"data" => $SponsorAd], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Sponsor Ad found."], 404);        
    }
}
