<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Status;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    public function index()
    {
        $status = Auth::user()->statuses;
        
        return response()->json(["status" => "success", "error" => false, "count" => count($status), "data" => $status],200);
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
            "stat_desc" => "required|min:3|unique:statuses,stat_desc",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors());
        }

        try {
            $status = Status::create([
                "stat_desc" => $request->stat_desc,               
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! status created."], 201);
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
        $status = Status::find($id);

        if($status) {
            return response()->json(["status" => "success", "error" => false, "data" => $status], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no status found."], 404);
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
        $status = Status::find($id);

        if($status) {
            $validator = Validator::make($request->all(), [
                'stat_desc' => 'required'
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors());
            }

            $status['stat_desc'] = $request->stat_desc;            

            $status->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! status updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no status found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Auth::user()->statuses->find($id);
        if($status) {
            $status->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! status deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no status found."], 404);
    }
}
