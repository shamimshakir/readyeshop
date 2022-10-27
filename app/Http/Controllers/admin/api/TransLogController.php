<?php

namespace App\Http\Controllers\admin\api;

use App\Models\TransLog;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransLogController extends Controller
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
        $translogs = TransLog::All();
        if($translogs) {
            return response()->json(["status" => "success", "error" => false, "count" => count($translogs),"data" => $translogs], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no TransLog found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no TransLog found."], 404);
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
            "trans_id" => "required|min:3|unique:trans_logs,trans_id",
            "trans_date" => "required",
            "result" => "required",
            "result_code" => "required",
            "prn" => "required",
            "card_number" => "required",
            "amount" => "required",
            "trans_desc" => "required",
            "transdate" => "required",
            "card_name" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $translogs = TransLog::create([
                "trans_id" => $request->trans_id,
                "trans_date" => $request->trans_date,
                "result" => $request->result,
                "result_code" => $request->result_code,
                "prn" => $request->prn,
                "card_number" => $request->card_number,
                "amount" => $request->amount,
                "trans_desc" => $request->trans_desc,
                "transdate" => $request->transdate,
                "card_name" => $request->card_name,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! TransLog created."], 201);
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
        $translogs = TransLog::find($id);
        if($translogs) {
            return response()->json(["status" => "success", "error" => false, "data" => $translogs], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no TransLog found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no TransLog found."], 404);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $translogs = Auth::user()->translogs->find($id);
        if($translogs) {
            $translogs->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! TransLog deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no TransLog found."], 404);
    }
}
