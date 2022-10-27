<?php

namespace App\Http\Controllers\admin\api;

use App\Models\SmsSetup;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\helper;
use App\Http\smshelper;

class SmsTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

   public function test(Request $request)
        {

             $validator = Validator::make($request->all(), [
                    "mobile" => "required",
                    "smsbody" => "required",
                    "sms_id" => "required"
                    ]);

                if($validator->fails()) {
                    return $this->validationErrors($validator->errors())->setStatusCode(422);
                }
            $sendsms =SmsSendSystem( $request->mobile, $request->smsbody, Auth::user()->id, $request->sms_id );

            if($sendsms==true) {

                return response()->json(["status" => "success", "error" => true, "message" => "Success! SMS Send."], 200);
            }else{
            return response()->json(["status" => "failed", "error" => false, "message" => "Failed To SMS send."], 404);
           }
        }
}
