<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Contact;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\Exception;
use App\Http\helper;
use App\Http\emailhelper;

class ContactController extends Controller
{
    public function store(Request $request)
        {

             $validator = Validator::make($request->all(), [
                    "fname" => "required",
                    "mobile" => "required",
                    "email" => "required",
                    "body" => "required",
                    ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
             Contact::create([
                "fname" => $request->fname,
                "lname" => $request->lname,
                "mobile" => $request->mobile,
                "email" => $request->email,
                "body" => $request->body,
                "subject" => $request->subject,
            ]);
        $email_id = pick('email_setups','id',"status",'1');

        if($email_id>0){
            $body="Dear ".$request->fname." </br> Thanks For contact Us </br> ";
            $sendemail =SendMails($request->email, $request->fname.' '.$request->lname , $request->subject, $body,'', $email_id);

            $recemail= pick('company_setups','contact_email','id','1');
            SendMails($recemail,' ', $request->subject, $request->body,'', $email_id);
        }              
        return response()->json(["status" => "success", "error" => false, "message" => "Success! Thanks For contact Us."], 201);
            
        }
        catch(Exception $exception) {
            return response()->json(["status" => "failed", "error" => $exception->getMessage()], 404);
        }

        }

        public function param(Request $request)
            {
               $user = Auth::user();
               if($user!=''){
                $contacts = Contact::select('*');
                if($request->email!=0){
                    $contacts = $contacts->where('contacts.email', '=', $request->email);
                }
                if($request->mobile!=0){
                    $contacts = $contacts->where('contacts.mobile', '=', $request->mobile);
                }
                if($request->name!=0){
                    $contacts = $contacts->where('contacts.fname', '=', $request->name);
                }
                if($request->start_date!='' && $request->end_date!=''){
                    $contacts = $contacts->whereBetween('contacts.created_at', [$request->start_date,$request->end_date]);
                }
                $contacts = $contacts->get();
                if($contacts) {
                    return response()->json(["status" => "success", "error" => false, "count" => count($contacts),"data" => $contacts], 200);
                }
                    return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no contacts found."], 404);
                }
                return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no contacts found."], 404);
            }
}
