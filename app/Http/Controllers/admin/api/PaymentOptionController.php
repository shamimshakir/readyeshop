<?php

namespace App\Http\Controllers\admin\api;

use App\Models\PaymentOption;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentOptionController extends Controller
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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/paymenticons/';
        $paymentoptions = PaymentOption::with('statuses')->get();
        if($paymentoptions) {
            return response()->json(["status" => "success", "error" => false,'url'=>$bdimageurl, "count" => count($paymentoptions),"data" => $paymentoptions], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no payment options found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no payment options found."], 404);
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
            "name" => "required|min:3|unique:payment_options,name",
            "pharm" => "required",
            "status" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $image=ImageUpload($request->file('logo'),'images/paymenticons/',90,40);
            $paymentoptions = PaymentOption::create([
                "name" => $request->name,
                "pharm" => $request->pharm,
                "status" => $request->status,
                "logo" => $image,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! payment options created."], 201);
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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/paymenticons/';
        $paymentoptions = PaymentOption::with('statuses')->where('payment_options.id', '=', $id)->get();
        if($paymentoptions) {
            return response()->json(["status" => "success", "error" => false, 'url'=>$bdimageurl,"count" => count($paymentoptions),"data" => $paymentoptions], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no payment options found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no payment options found."], 404);
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
        $paymentoptions = PaymentOption::find($id);
        if($user!='' && $paymentoptions){
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "pharm" => "required",
                "status" => "required",
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            if($request->file('logo')!=''){
               $image=ImageUpload($request->file('logo'),'images/paymenticons/',90,40);
               $paymentoptions['logo'] = $image;
            }
            $paymentoptions['name'] = $request->name;
            $paymentoptions['pharm'] = $request->pharm;
            $paymentoptions['status'] = $request->status;
            $paymentoptions->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! payment options updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no payment options found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentoptions = Auth::user()->paymentoptions->find($id);
        if($paymentoptions) {
            $paymentoptions->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! payment options deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no payment options found."], 404);
    }


    public function status()
    {
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/paymenticons/';
        $paymentoptions = PaymentOption::where('payment_options.status','1')->get();
        if($paymentoptions) {
            return response()->json(["status" => "success", "error" => false, 'url'=>$bdimageurl,"count" => count($paymentoptions),"data" => $paymentoptions], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no payment options found."], 404);
        
    }

    public function payments(Request $request)
    {
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/paymenticons/';
        $paymentoptions = PaymentOption::where('payment_options.status','1')->where('payment_options.id','=',$request->id)->get();
        if($paymentoptions) {
            return response()->json(["status" => "success", "error" => false, 'url'=>$bdimageurl,"count" => count($paymentoptions),"data" => $paymentoptions], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no payment options found."], 404);
        
    }
    public function param(Request $request)
    {
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/paymenticons/';
        $paymentoptions = PaymentOption::where('payment_options.status','1')->get();
        if($paymentoptions) {
            return response()->json(["status" => "success", "error" => false, 'url'=>$bdimageurl,"count" => count($paymentoptions),"data" => $paymentoptions], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no payment options found."], 404);
        
    }
}
