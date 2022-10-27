<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class LanguageController extends Controller
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
       
        $language = Language::All();
        if($language) {
            return response()->json(["status" => "success", "error" => false, "count" => count($language),"data" => $language], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no language found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no language found."], 404);
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
            "en" => "required|min:3|unique:languages,en",
            "bn" => "required"            
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $language = Language::create([
                "en" => $request->en,
                "bn" => $request->bn,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! language created."], 201);           
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
       
        $language = Language::find($id);
        if($language) {
            return response()->json(["status" => "success", "error" => false,"data" => $language], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no language found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no language found."], 404);
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
        $language = Language::find($id);
        if($user!='' && $language){
            $validator = Validator::make($request->all(), [                
                "en" => "required",
                "bn" => "required"   
                ]);            
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }                
            $language['bn'] = $request->bn;
            $language['en'] = $request->en;
            $language->save();               
            return response()->json(["status" => "success", "error" => false, "message" => "Success! language updated."], 201);                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no language found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $language = Auth::user()->languages->find($id);
        if($language) {
            $language->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! language deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no language found."], 404);
    }
}
