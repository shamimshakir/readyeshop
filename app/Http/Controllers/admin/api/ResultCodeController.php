<?php

namespace App\Http\Controllers\admin\api;

use App\Models\ResultCode;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResultCodeController extends Controller
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
        $resultcodes = ResultCode::All();
        if($resultcodes) {
            return response()->json(["status" => "success", "error" => false, "count" => count($resultcodes),"data" => $resultcodes], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ResultCode found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ResultCode found."], 404);
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
            "result_code" => "required|min:3|unique:result_codes,result_code",
            "result_type" => "required",
            "result_desc" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $resultcodes = ResultCode::create([
                "result_code" => $request->result_code,
                "result_type" => $request->result_type,
                "result_desc" => $request->result_desc,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! ResultCode created."], 201);
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
        $resultcodes = ResultCode::find($id);
        if($resultcodes) {
            return response()->json(["status" => "success", "error" => false, "count" => count($resultcodes),"data" => $resultcodes], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ResultCode found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ResultCode found."], 404);
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
        $resultcodes = ResultCode::find($id);
        if($user!='' && $resultcodes){
            $validator = Validator::make($request->all(), [
                "result_code" => "required",
                "result_type" => "required",
                "result_desc" => "required",
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $resultcodes['result_code'] = $request->result_code;
            $resultcodes['result_type'] = $request->result_type;
            $resultcodes['result_desc'] = $request->result_desc;
            $resultcodes->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! ResultCode updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no ResultCode found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $resultcodes = Auth::user()->resultcodes->find($id);
        if($resultcodes) {
            $resultcodes->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! ResultCode deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no ResultCode found."], 404);
    }
}
