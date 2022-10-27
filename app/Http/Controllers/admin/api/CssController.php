<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Css;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CssController extends Controller
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
        $csses = Css::All();
        if($csses) {
            return response()->json(["status" => "success", "error" => false, "count" => count($csses),"data" => $csses], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Css found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Css found."], 404);
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
            "label" => "required",
            "item" => "required",
            "item_value" => "required",
            "status" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $csses = Css::create([
                "label" => $request->label,
                "item" => $request->item,
                "item_value" => $request->item_value,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Css created."], 201);
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
        $csses = Css::find($id);
        if($csses) {
            return response()->json(["status" => "success", "error" => false, "data" => $csses], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Css found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Css found."], 404);
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
        $csses = Css::find($id);
        if($user!='' && $csses){
            $validator = Validator::make($request->all(), [
                "label" => "required",
                "item" => "required",
                "item_value" => "required",
                "status" => "required",
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $csses['label'] = $request->label;
            $csses['item'] = $request->item;
            $csses['item_value'] = $request->item_value;
            $csses['status'] = $request->status;
            $csses->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Css updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Css found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $csses = Auth::user()->csses->find($id);
        if($csses) {
            $csses->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Css deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Css found."], 404);
    }
}
