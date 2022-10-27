<?php

namespace App\Http\Controllers\admin\api;

use App\Models\ThirdpartyAuth;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;

class ThirdpartyAuthController extends Controller
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
        $thirdpartyauths = ThirdpartyAuth::with('statuses')->get();
        if($thirdpartyauths) {
            return response()->json(["status" => "success", "error" => false, "count" => count($thirdpartyauths),"data" => $thirdpartyauths], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Third Party Auth found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Third Party Auth found."], 404);
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
            "app_id" => "required",
            "app_secret" => "required",
            "default_graph_version" => "required",
            "name" => "required",
            "url" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $thirdpartyauths = ThirdpartyAuth::create([
                "app_id" => $request->app_id,
                "app_secret" => $request->app_secret,
                "default_graph_version" => $request->default_graph_version,
                "name" => $request->name,
                "url" => $request->url,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Third Party Auth created."], 201);
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
        $thirdpartyauths = ThirdpartyAuth::with('statuses')->find($id);
        if($thirdpartyauths) {
            return response()->json(["status" => "success", "error" => false, "data" => $thirdpartyauths], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Third Party Auth found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Third Party Auth found."], 404);
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
        $thirdpartyauths = ThirdpartyAuth::find($id);
        if($user!='' && $thirdpartyauths){
            $validator = Validator::make($request->all(), [
                "app_id" => "required",
                "app_secret" => "required",
                "default_graph_version" => "required",
                "name" => "required",
                "url" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            $thirdpartyauths['app_id'] = $request->app_id;
            $thirdpartyauths['app_secret'] = $request->app_secret;
            $thirdpartyauths['default_graph_version'] = $request->default_graph_version;
            $thirdpartyauths['name'] = $request->name;
            $thirdpartyauths['url'] = $request->url;
            $thirdpartyauths['status'] = $request->status;
            $thirdpartyauths->save();

            $domain=parse_url(request()->root())['host'];
            
            if($request->name=='facebook'){
                envUpdate($domain,'FACEBOOK_ID', $request->app_id);
                envUpdate($domain,'FACEBOOK_SECRET', $request->app_secret);
            }elseif($request->name=='google'){
                envUpdate($domain,'GOOGLE_ID', $request->app_id);
                envUpdate($domain,'GOOGLE_SECRET', $request->app_secret);
            }elseif($request->name=='github'){
                envUpdate($domain,'GITHUB_ID', $request->app_id);
                envUpdate($domain,'GITHUB_SECRET', $request->app_secret);
            }elseif($request->name=='github'){
                envUpdate($domain,'TWITTER_ID', $request->app_id);
                envUpdate($domain,'TWITTER_SECRET', $request->app_secret);
            }
            

            return response()->json(["status" => "success", "error" => false, "message" => "Success! Third Party Auth updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Third Party Auth found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $thirdpartyauths = Auth::user()->thirdpartyauths->find($id);
        if($thirdpartyauths) {
            $thirdpartyauths->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Third Party Auth deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Third Party Auth found."], 404);
    }


    public function param(Request $request)
    {

        $thirdpartyauths = ThirdpartyAuth::select('*');

        if($request->id>0){
            $thirdpartyauths = $thirdpartyauths->where('thirdparty_auths.id', '=', $request->id);
        }
        if($request->status>0){
            $thirdpartyauths = $thirdpartyauths->Where('thirdparty_auths.status', '=', $request->status);
        }
        if($request->name!=''){
            $thirdpartyauths = $thirdpartyauths->Where('thirdparty_auths.name', '=', $request->name);
        }
       
        $thirdpartyauths = $thirdpartyauths->get();
        
        if($thirdpartyauths) {
            return response()->json(["status" => "success", "error" => false, "count" => count($thirdpartyauths),"data" => $thirdpartyauths], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
