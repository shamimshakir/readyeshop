<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Level;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
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
        $levels = Level::All();
        if($levels) {
            return response()->json(["status" => "success", "error" => false, "count" => count($levels),"data" => $levels], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Level found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Level found."], 404);
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
            "name" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $levels = Level::create([
                "name" => $request->name,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Level created."], 201);
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
        $levels = Level::All();
        if($levels) {
            return response()->json(["status" => "success", "error" => false, "count" => count($levels),"data" => $levels], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Level found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Level found."], 404);
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
        $levels = Level::find($id);
        if($user!='' && $levels){
            $validator = Validator::make($request->all(), [
                "name" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $levels['name'] = $request->name;
            $levels->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Level updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Level found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $levels = Auth::user()->levels->find($id);
        if($levels) {
            $levels->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Level deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Level found."], 404);
    }
}
