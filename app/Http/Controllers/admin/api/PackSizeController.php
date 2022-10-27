<?php

namespace App\Http\Controllers\admin\api;

use App\Models\PackSize;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PackSizeController extends Controller
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
        $packsizes = PackSize::with('statuses')->get();
        if($packsizes) {
            return response()->json(["status" => "success", "error" => false, "count" => count($packsizes),"data" => $packsizes], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Pack Size found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Pack Size found."], 404);
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
            "packweight" => "required",
            "packheight" => "required",
            "packwidth" => "required",
            "packlength" => "required",
            "cubicsize" => "required",
            "status" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $packsizes = PackSize::create([
                "packweight" => $request->packweight,
                "packheight" => $request->packheight,
                "packwidth" => $request->packwidth,
                "packlength" => $request->packlength,
                "cubicsize" => $request->cubicsize,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Pack Size created."], 201);
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

        $packsizes = PackSize::with('statuses')->where('pack_sizes.id', '=', $id)->get();
        if($packsizes) {
            return response()->json(["status" => "success", "error" => false, "count" => count($packsizes),"data" => $packsizes], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Pack Size found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Pack Size found."], 404);
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
        $packsizes = PackSize::find($id);
        if($user!='' && $packsizes){
            $validator = Validator::make($request->all(), [
                "packweight" => "required",
                "packheight" => "required",
                "packwidth" => "required",
                "packlength" => "required",
                "cubicsize" => "required",
                "status" => "required",
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $packsizes['packweight'] = $request->packweight;
            $packsizes['packheight'] = $request->packheight;
            $packsizes['packwidth'] = $request->packwidth;
            $packsizes['packlength'] = $request->packlength;
            $packsizes['cubicsize'] = $request->cubicsize;
            $packsizes['status'] = $request->status;
            $packsizes->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! Pack Size updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Pack Size found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $packsizes = Auth::user()->packsizes->find($id);
        if($packsizes) {
            $packsizes->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Pack Size deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Pack Size found."], 404);
    }
}
