<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\Adv;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class AdvController extends Controller
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
        $advimageurl= url($_SERVER['SERVER_NAME']).'/images/adv/';
        $adv = Adv::with('Status')->get();
        if($adv) {
            return response()->json(["status" => "success", "error" => false, "count" => count($adv),'url'=>$advimageurl,"data" => $adv], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no adv found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no adv found."], 404);
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
            "comp_name" => "required|min:3|unique:advs,comp_name",
            "business_type" => "required",
            "adv_position" => "required",
            "comp_url" => "required",
            "comp_status" => "required",
            "start_date" => "required",
            "end_date" => "required",
            "comp_image" => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $comp_image=ImageUpload($request->file('comp_image'),'images/adv/',1155,145);
            $adv = Adv::create([
                "comp_name" => $request->comp_name,
                "business_type" => $request->business_type,
                "adv_position" => $request->adv_position,
                "comp_url" => $request->comp_url,
                "comp_status" => $request->comp_status,               
                "start_date" => $request->start_date,
                "end_date" => $request->end_date,
                "comp_image" => $comp_image,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! adv created."], 201);
           
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
        $advimageurl= url($_SERVER['SERVER_NAME']).'/images/adv/';
        $adv = Adv::with('Status')->where('advs.id', '=', $id)->get();
        if($adv) {
            return response()->json(["status" => "success", "error" => false, "count" => count($adv),'url'=>$advimageurl,"data" => $adv], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no adv found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no adv found."], 404);
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
        $adv = Adv::find($id);
        if($user!='' && $adv){
            $validator = Validator::make($request->all(), [                
                "comp_name" => "required",
                "business_type" => "required",
                "adv_position" => "required",
                "comp_url" => "required",
                "comp_status" => "required",              
                "start_date" => "required",
                "end_date" => "required"
                ]);

                if($validator->fails()) {
                    return $this->validationErrors($validator->errors())->setStatusCode(422);
                }

                if($request->file('comp_image')!=''){
                   $comp_image=ImageUpload($request->file('comp_image'),'images/adv/',1155,145);
                   $adv['comp_image'] = $comp_image;
                }
                $adv['comp_name'] = $request->comp_name;
                $adv['business_type'] = $request->business_type;
                $adv['adv_position'] = $request->adv_position;
                $adv['comp_url'] = $request->comp_url;
                $adv['comp_status'] = $request->comp_status;
                $adv['start_date'] = $request->start_date;
                $adv['end_date'] = $request->end_date;
                $adv->save(); 
               
             return response()->json(["status" => "success", "error" => false, "message" => "Success! adv updated."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no adv found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adv = Auth::user()->advs->find($id);
        if($adv) {
            $adv->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! adv deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no adv found."], 404);
    }
}
