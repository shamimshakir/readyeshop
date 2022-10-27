<?php

namespace App\Http\Controllers\admin\api;

use App\Models\HomePageConfig;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomePageConfigController extends Controller
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
        $homepageconfigs = HomePageConfig::with('statuses')->get();
        if($homepageconfigs) {
            return response()->json(["status" => "success", "error" => false, "count" => count($homepageconfigs),"data" => $homepageconfigs], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
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
            "name" => "required|min:3|unique:home_page_configs,name",
            "status" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $homepageconfigs = HomePageConfig::create([
                "name" => $request->name,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! home page configs created."], 201);
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
        $homepageconfigs = HomePageConfig::with('statuses')->where('home_page_configs.id', '=', $id)->get();
        if($homepageconfigs) {
            return response()->json(["status" => "success", "error" => false, "count" => count($homepageconfigs),"data" => $homepageconfigs], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
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
        $homepageconfigs = HomePageConfig::find($id);
        if($user!='' && $homepageconfigs){
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "status" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $homepageconfigs['name'] = $request->name;
            $homepageconfigs['status'] = $request->status;
            $homepageconfigs->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! home page configs updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no home page configs found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $homepageconfigs = Auth::user()->homepageconfigs->find($id);
        if($homepageconfigs) {
            $homepageconfigs->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! home page configs deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no home page configs found."], 404);
    }
}
