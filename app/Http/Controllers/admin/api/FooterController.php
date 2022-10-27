<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\Footer;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class FooterController extends Controller
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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/footer/';
        $footers = Footer::All();
        if($footers) {
            return response()->json(["status" => "success", "error" => false, "count" => count($footers),'url'=>$bdimageurl,"data" => $footers], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Footer found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Footer found."], 404);
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
            "footer_phone" => "required",
            "footer_contact" => "required",
            "footer_logo" => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $footer_logo=ImageUpload($request->file('footer_logo'),'images/footer/',90,40);
            $footers = Footer::create([
                "footer_phone" => $request->footer_phone,
                "footer_logo" => $footer_logo,
                "footer_contact" => $request->footer_contact,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Footer created."], 201);
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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/footer/';
        $footers = Footer::find($id);
        if($footers) {
            return response()->json(["status" => "success", "error" => false, 'url'=>$bdimageurl,"data" => $footers], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Footer found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Footer found."], 404);
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
        $footers = Footer::find($id);
        if($user!='' && $footers){
            $validator = Validator::make($request->all(), [
                "footer_phone" => "required",
                "footer_contact" => "required",
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

                if($request->file('footer_logo')!=''){
                   $footer_logo=ImageUpload($request->file('footer_logo'),'images/footer/',90,40);
                   $footers['footer_logo'] = $footer_logo;
                }

                $footers['footer_phone'] = $request->footer_phone;
                $footers['footer_contact'] = $request->footer_contact;
                $footers->save(); 
               
             return response()->json(["status" => "success", "error" => false, "message" => "Success! Footer updated."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Footer found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $footers = Auth::user()->footers->find($id);
        if($footers) {
            $footers->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Footer deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Footer found."], 404);
    }

    public function param(Request $request)
    {
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/footer/';
        $footers = Footer::All();
        
        if($footers) {
            return response()->json(["status" => "success", "error" => false, "count" => count($footers),'url'=>$bdimageurl,"data" => $footers], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Payment Icon found."], 404);        
    }
}
