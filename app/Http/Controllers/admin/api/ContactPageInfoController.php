<?php

namespace App\Http\Controllers\admin\api;

use App\Models\ContactPageInfo;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactPageInfoController extends Controller
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
        $contactpageinfos = ContactPageInfo::All();
        if($contactpageinfos) {
            return response()->json(["status" => "success", "error" => false, "count" => count($contactpageinfos),"data" => $contactpageinfos], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ContactPageInfo found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ContactPageInfo found."], 404);
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
            "contact_address" => "required",
            "contact_phone" => "required",
            "contact_email" => "required",
            "contact_map_location" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $contactpageinfos = ContactPageInfo::create([
                "contact_address" => $request->contact_address,
                "contact_phone" => $request->contact_phone,
                "contact_email" => $request->contact_email,
                "contact_map_location" => $request->contact_map_location,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! ContactPageInfo created."], 201);
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
        $contactpageinfos = ContactPageInfo::All();
        if($contactpageinfos) {
            return response()->json(["status" => "success", "error" => false, "count" => count($contactpageinfos),"data" => $contactpageinfos], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ContactPageInfo found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ContactPageInfo found."], 404);
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
        $contactpageinfos = ContactPageInfo::find($id);
        if($user!='' && $contactpageinfos){
            $validator = Validator::make($request->all(), [
                "contact_address" => "required",
                "contact_phone" => "required",
                "contact_email" => "required",
                "contact_map_location" => "required",
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $contactpageinfos['contact_address'] = $request->contact_address;
            $contactpageinfos['contact_phone'] = $request->contact_phone;
            $contactpageinfos['contact_email'] = $request->contact_email;
            $contactpageinfos['contact_map_location'] = $request->contact_map_location;
            $contactpageinfos->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! ContactPageInfo updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no ContactPageInfo found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $contactpageinfos = Auth::user()->contactpageinfos->find($id);
        if($contactpageinfos) {
            $contactpageinfos->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! ContactPageInfo deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no ContactPageInfo found."], 404);
    }
}
