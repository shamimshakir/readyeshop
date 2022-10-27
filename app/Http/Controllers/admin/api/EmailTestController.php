<?php

namespace App\Http\Controllers\admin\api;

use App\Models\EmailSetup;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\Exception;
use App\Http\helper;
use App\Http\emailhelper;

class EmailTestController extends Controller
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
                    "clientemailaddress" => "required",
                    "subject" => "required",
                    "body" => "required",
                    "email_id" => "required",
                    ]);

                if($validator->fails()) {
                    return $this->validationErrors($validator->errors())->setStatusCode(422);
                }
            $sendemail =
            SendMails($request->clientemailaddress, $request->clientname, $request->subject, $request->body,Auth::user()->id, $request->email_id);

            if($sendemail==true) {

                return response()->json(["status" => "success", "error" => true, "message" => "Success! Email Send."], 200);
            }else{
            return response()->json(["status" => "failed", "error" => false, "message" => "Failed To Email send."], 404);
           }
        }

    public function composeEmail(Request $request) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug =0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'emailtestnex@gmail.com';   //  sender username
            $mail->Password = 'Emailtestnex@#';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            $mail->setFrom('emailtestnex@gmail.com', 'Nextech');
            $mail->addAddress($request->emailRecipient);
            $mail->addCC($request->emailCc);
            $mail->addBCC($request->emailBcc);

            $mail->addReplyTo('emailtestnex@gmail.com', 'Nextech');

            /*if(isset($_FILES['emailAttachments'])) {
                for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }*/


            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $request->emailSubject;
            $mail->Body    = $request->emailBody;

            // $mail->AltBody = plain text version of email body;

            if( !$mail->send() ) {
                return response()->json(["status" => "Fail", "error" => true, "message" => $mail->ErrorInfo], 422);

            }
            else {
                return response()->json(["status" => "Success", "error" => true, "message" =>'Email has been sent.'], 200);

              //  return back()->with("success", "Email has been sent.");
            }

        } catch (Exception $e) {
               return response()->json(["status" => "Fail", "error" => true, "message" =>'Message could not be sent.'], 422);

        }
    }

}
