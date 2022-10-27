<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\PaymentIcon;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;
class PaymentIconController extends Controller
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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/PaymentIcon/';
        $PaymentIcon = PaymentIcon::with('statuses')->get();
        if($PaymentIcon) {
            return response()->json(["status" => "success", "error" => false, "count" => count($PaymentIcon),'url'=>$bdimageurl,"data" => $PaymentIcon], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no PaymentIcon found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no PaymentIcon found."], 404);
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
            "name" => "required|min:3|unique:payment_icons,name",
            "status" => "required",
            "logo" => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $image=ImageUpload($request->file('logo'),'images/PaymentIcon/',26,26);
            $PaymentIcon = PaymentIcon::create([
                "name" => $request->name,
                "status" => $request->status,
                "logo" => $image,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! PaymentIcon created."], 201);

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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/PaymentIcon/';
        $PaymentIcon = PaymentIcon::with('statuses')->where('payment_icons.id', '=', $id)->get();
        if($PaymentIcon) {
            return response()->json(["status" => "success", "error" => false, "count" => count($PaymentIcon),'url'=>$bdimageurl,"data" => $PaymentIcon], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no PaymentIcon found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no PaymentIcon found."], 404);
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
        $PaymentIcon = PaymentIcon::find($id);
        if($user!='' && $PaymentIcon){
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "status" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
                if($request->file('logo')!=''){
                   $image=ImageUpload($request->file('logo'),'images/PaymentIcon/',26,26);
                   $PaymentIcon['logo'] = $image;
                }
                $PaymentIcon['name'] = $request->name;
                $PaymentIcon['status'] = $request->status;
                $PaymentIcon->save();
             return response()->json(["status" => "success", "error" => false, "message" => "Success! PaymentIcon updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no PaymentIcon found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $PaymentIcon = Auth::user()->PaymentIcons->find($id);
        if($PaymentIcon) {
            $PaymentIcon->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! PaymentIcon deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no PaymentIcon found."], 404);
    }


    public function param(Request $request)
    {
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/PaymentIcon/';
        $PaymentIcon = PaymentIcon::with('statuses');

        if($request->id>0){
            $PaymentIcon = $PaymentIcon->where('payment_icons.id', '=', $request->id);
        }
        if($request->status>0){
            $PaymentIcon = $PaymentIcon->Where('payment_icons.status', '=', $request->status);
        }
        if($request->name!=''){
            $PaymentIcon = $PaymentIcon->Where('payment_icons.name', '=', $request->name);
        }
        
        $PaymentIcon = $PaymentIcon->get();
        
        if($PaymentIcon) {
            return response()->json(["status" => "success", "error" => false, "count" => count($PaymentIcon),'url'=>$bdimageurl,"data" => $PaymentIcon], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Payment Icon found."], 404);        
    }
}
