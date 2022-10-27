<?php

namespace App\Http\Controllers\admin\api;

use App\Models\CustomerType;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerTypeController extends Controller
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
        $custometypes = CustomerType::All();
        if($custometypes) {
            return response()->json(["status" => "success", "error" => false, "count" => count($custometypes),"data" => $custometypes], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no custome types found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no custome types found."], 404);
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
            "cl_type_description" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $custometypes = CustomerType::create([
                "cl_type_description" => $request->cl_type_description,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! custome types created."], 201);
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

        $custometypes = CustomerType::find($id);
        if($custometypes) {
            return response()->json(["status" => "success", "error" => false, "data" => $custometypes], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no custome types found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no custome types found."], 404);
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
        $custometypes = CustomerType::find($id);
        if($user!='' && $custometypes){
            $validator = Validator::make($request->all(), [
                "cl_type_description" => "required",
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $custometypes['cl_type_description'] = $request->cl_type_description;
            $custometypes->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! custome types updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no custome types found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $custometypes = Auth::user()->custometypes->find($id);
        if($custometypes) {
            $custometypes->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! custome types deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no custome types found."], 404);
    }
}
