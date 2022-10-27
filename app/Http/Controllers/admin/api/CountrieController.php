<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Countrie;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CountrieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Auth::user()->countries; 
              
        return response()->json(["status" => "success", "error" => false, "count" => count($countries), "data" => $countries],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {
        
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "sortname" => "required|min:3|max:3|unique:countries,sortname",
            "name" => "required",
            "phonecode"=>"required" 
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $countrie = Countrie::create([
                "sortname" => $request->sortname,
                "name" => $request->name,
                "phonecode" => $request->phonecode,
                "user_id" => Auth::user()->id,
                "entry_date" => date('Y-m-d H:i:s')
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! countries created."], 201);
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
        $country=Countrie::select("countries.id", 
                            "countries.sortname",
                            "countries.name",
                            "countries.phonecode",
                            "countries.user_id",
                            "countries.created_at",
                            "countries.updated_at"
                        )
                        ->where('countries.id', '=', $id)                      
                        ->get();
        if($country) {
            return response()->json(["status" => "success", "error" => false, "count" => count($country), "data" => $country], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no country found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no country found."], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit($id)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $countrie = Countrie::find($id);

        if($countrie) {
            $validator = Validator::make($request->all(), [                
                "sortname" => "required",
                "name" => "required"
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $countrie['sortname'] = $request->sortname;
            $countrie['name'] = $request->name;            

            $countrie->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! countries updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no countries found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $countrie = Auth::user()->countries->find($id);
        if($countrie) {
            $countrie->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! countries deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no countries found."], 404);
    }

    public function param(Request $request)
    {
       
        $country=Countrie::select("countries.id", 
                            "countries.sortname",
                            "countries.name",
                            "countries.phonecode"
                        );
        if($request->id>0){
            $country = $country->where('countries.id', '=', $request->id);
        }
                                           
        $country=$country->get();
        if($country) {
            return response()->json(["status" => "success", "error" => false, "count" => count($country), "data" => $country], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no country found."], 404);
       
    }
}
