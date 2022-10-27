<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Icon;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IconController extends Controller
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
       $icon=Icon::select("icons.id", 
                            "icons.name",
                            "icons.user_id",
                            "icons.type_id",
                            "icons.created_at",
                            "icons.updated_at",
                            "icon_types.name as icon_types_name"
                        )
                        ->join("icon_types", "icon_types.id", "=", "icons.type_id")
                        ->get();      
        if($icon) {
            return response()->json(["status" => "success", "error" => false, "count" => count($icon),"data" => $icon], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no icon found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no icon found."], 404);
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
            "name" => "required|min:3|unique:icons,name",
            "type_id" => "required",
            
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors());
        }

        try {
            $icon = Icon::create([
                "name" => $request->name,
                "type_id" => $request->type_id,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! icon created."], 201);
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
        //$district = Auth::user()->districts->find($id);
        $user = Auth::user();
        if($user!=''){
           $icon=Icon::select("icons.id", 
                            "icons.name",
                            "icons.user_id",
                            "icons.type_id",
                            "icons.created_at",
                            "icons.updated_at",
                            "icon_types.name as icon_types_name"
                        )
                        ->join("icon_types", "icon_types.id", "=", "icons.type_id")
                        ->where('icons.id', '=', $id)
                        ->get();        

        if($icon) {
            return response()->json(["status" => "success", "error" => false, "count" => count($icon), "data" => $icon], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no icon found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no icon found."], 404);
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
        $icon = Icon::find($id); 
        
        if($icon) {
            $validator = Validator::make($request->all(), [                
                "name" => "required",
                "type_id" => "required",
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors());
            }

            $icon['name'] = $request->name;  
            $icon['type_id'] = $request->type_id;  
                    

            $icon->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! icon updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no icon found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $icon = Auth::user()->icon->find($id);
        if($icon) {
            $icon->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! icon deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no icon found."], 404);
    }
}
