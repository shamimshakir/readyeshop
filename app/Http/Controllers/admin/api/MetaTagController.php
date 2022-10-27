<?php

namespace App\Http\Controllers\admin\api;

use App\Models\MetaTag;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MetaTagController extends Controller
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
        $metatags = MetaTag::with('statuses')->get();
        if($metatags) {
            return response()->json(["status" => "success", "error" => false, "count" => count($metatags),"data" => $metatags], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no meta tag found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no meta tag found."], 404);
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
            "meta_page" => "required",
            "meta_name" => "required",
            "meta_content" => "required",
            "meta_type" => "required",
            "status" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $metatags = MetaTag::create([
                "meta_page" => $request->meta_page,
                "meta_name" => $request->meta_name,
                "meta_content" => $request->meta_content,
                "meta_type" => $request->meta_type,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! meta tag created."], 201);
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

        $metatags = MetaTag::with('statuses')->where('meta_tags.id', '=', $id)->get();
        if($metatags) {
            return response()->json(["status" => "success", "error" => false, "count" => count($metatags),"data" => $metatags], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no meta tag found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no meta tag found."], 404);
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
        $metatags = MetaTag::find($id);
        if($user!='' && $metatags){
            $validator = Validator::make($request->all(), [
                "meta_page" => "required",
                "meta_name" => "required",
                "meta_content" => "required",
                "meta_type" => "required",
                "status" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $metatags['meta_page'] = $request->meta_page;
            $metatags['meta_name'] = $request->meta_name;
            $metatags['meta_content'] = $request->meta_content;
            $metatags['meta_type'] = $request->meta_type;
            $metatags['status'] = $request->status;
            $metatags->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! meta tag updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no meta tag found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $metatags = Auth::user()->metatags->find($id);
        if($metatags) {
            $metatags->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! meta tag deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no meta tag found."], 404);
    }


    public function param(Request $request)
    {
        $metatags = MetaTag::select('*');
        if($request->meta_page!=''){
            $metatags = $metatags->where('meta_tags.meta_page', '=', $request->meta_page);
        }
        if($request->status>0){
            $metatags = $metatags->Where('meta_tags.status', '=', $request->status);
        }
        $metatags = $metatags->get();        
        if($metatags) {
            return response()->json(["status" => "success", "error" => false, "count" => count($metatags),"data" => $metatags], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Meta found."], 404);        
    }
}
