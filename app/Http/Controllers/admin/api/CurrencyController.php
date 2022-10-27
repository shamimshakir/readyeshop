<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Currency;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
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

        $currencies = Currency::with('statuses')->get();
        if($currencies) {
            return response()->json(["status" => "success", "error" => false, "count" => count($currencies),"data" => $currencies], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms setup found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no sms setup found."], 404);
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
            "cy_code" => "required|min:3|unique:currencies,cy_code",
            "cy_symbol" => "required",
            "status" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $currencies = Currency::create([
                "cy_code" => $request->cy_code,
                "cy_symbol" => $request->cy_symbol,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! currencies created."], 201);
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

        $currencies = Currency::with('statuses')->where('currencies.id', '=', $id)->get();
        if($currencies) {
            return response()->json(["status" => "success", "error" => false, "count" => count($currencies),"data" => $currencies], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Currency found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Currency found."], 404);
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
        $currencies = Currency::find($id);
        if($user!='' && $currencies){
            $validator = Validator::make($request->all(), [
                "cy_code" => "required",
                "status" => "required",
                "cy_symbol" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $currencies['cy_code'] = $request->cy_code;
            $currencies['status'] = $request->status;
            $currencies['cy_symbol'] = $request->cy_symbol;
            $currencies->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! Currency updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no currencies found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currencies = Auth::user()->currencies->find($id);
        if($currencies) {
            $currencies->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! currencies deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no currencies found."], 404);
    }
}
