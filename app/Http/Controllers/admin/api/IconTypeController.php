<?php

namespace App\Http\Controllers\admin\api;

use App\Models\IconType;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IconTypeController extends Controller
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
       $icontype=IconType::select("icon_types.id", 
                            "icon_types.name",
                            "icon_types.user_id",
                            "icon_types.created_at",
                            "icon_types.updated_at"
                        )
                        ->get();      
        if($icontype) {
            return response()->json(["status" => "success", "error" => false, "count" => count($icontype),"data" => $icontype], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no icontype found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no icontype found."], 404);
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
            "name" => "required|min:3|unique:icon_types,name"
            
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors());
        }

        try {
            $icontype = IconType::create([
                "name" => $request->name,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! icontype created."], 201);
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
            $icontype=IconType::select("icon_types.id", 
                            "icon_types.name",
                            "icon_types.user_id",
                            "icon_types.created_at",
                            "icon_types.updated_at"
                        )
                        ->where('icon_types.id', '=', $id)
                        ->get();        

        if($icontype) {
            return response()->json(["status" => "success", "error" => false, "count" => count($icontype), "data" => $icontype], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no icontype found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no icontype found."], 404);
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
        $icontypes = IconType::find($id); 
        
        if($icontypes) {
            $validator = Validator::make($request->all(), [                
                "name" => "required"
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors());
            }

            $icontypes['name'] = $request->name;  
                    

            $icontypes->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! icontype updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no icontype found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $icontype = Auth::user()->icontype->find($id);
        if($icontype) {
            $icontype->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! icontype deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no icontype found."], 404);
    }
}
