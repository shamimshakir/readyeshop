<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
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
        $tags = Tag::All();
        if($tags) {
            return response()->json(["status" => "success", "error" => false, "count" => count($tags),"data" => $tags], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tag found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tag found."], 404);
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
            "name" => "required|min:3|unique:tags,name"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $tags = Tag::create([
                "name" => $request->name,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! tag created."], 201);
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
        $tags = Tag::find($id);
        if($tags) {
            return response()->json(["status" => "success", "error" => false, "count" => count($tags),"data" => $tags], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tag found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tag found."], 404);
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
        $tags = Tag::find($id);
        if($user!='' && $tags){
            $validator = Validator::make($request->all(), [
                "name" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $tags['name'] = $request->name;
            $tags->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! tag updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no tag found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $tags = Auth::user()->tags->find($id);
        if($tags) {
            $tags->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! tag deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no tag found."], 404);
    }
}
