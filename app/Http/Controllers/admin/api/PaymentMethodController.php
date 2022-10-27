<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;
class PaymentMethodController extends Controller
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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/paymentmethod/';
        $PaymentMethod = PaymentMethod::with('statuses')->get();
        if($PaymentMethod) {
            return response()->json(["status" => "success", "error" => false, "count" => count($PaymentMethod),'url'=>$bdimageurl,"data" => $PaymentMethod], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no PaymentMethod found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no PaymentMethod found."], 404);
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
            "payment_method" => "required|min:3|unique:payment_methods,payment_method",
            "status" => "required",
            "icon_img" => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $image=ImageUpload($request->file('icon_img'),'images/paymentmethod/',90,40);
            $PaymentMethod = PaymentMethod::create([
                "payment_method" => $request->payment_method,
                "status" => $request->status,
                "icon_img" => $image,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! PaymentMethod created."], 201);

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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/paymentmethod/';
        $PaymentMethod = PaymentMethod::with('statuses')->where('payment_methods.id', '=', $id)->get();
        if($PaymentMethod) {
            return response()->json(["status" => "success", "error" => false, "count" => count($PaymentMethod),'url'=>$bdimageurl,"data" => $PaymentMethod], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no PaymentMethod found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no PaymentMethod found."], 404);
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
        $PaymentMethod = PaymentMethod::find($id);
        if($user!='' && $PaymentMethod){
            $validator = Validator::make($request->all(), [
                "payment_method" => "required",
                "status" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
                if($request->file('icon_img')!=''){
                   $image=ImageUpload($request->file('icon_img'),'images/paymentmethod/',90,40);
                   $PaymentMethod['icon_img'] = $image;
                }
                $PaymentMethod['payment_method'] = $request->payment_method;
                $PaymentMethod['status'] = $request->status;
                $PaymentMethod->save();
             return response()->json(["status" => "success", "error" => false, "message" => "Success! PaymentMethod updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no PaymentMethod found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $PaymentMethod = Auth::user()->paymentmethods->find($id);
        if($PaymentMethod) {
            $PaymentMethod->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! PaymentMethod deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no PaymentMethod found."], 404);
    }
}
