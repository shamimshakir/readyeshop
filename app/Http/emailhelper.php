<?php
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;

// ========== [ Compose Email ] ================
function SendMails($clientemailaddress, $clientname, $subject, $body,$user_id, $email_id=NULL ) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            $query = DB::table('email_setups');
            if($email_id!=''){
                $query->where('id',$email_id);
            }else{
                $query->where('status','1');
            }
            $data = $query->get();
            foreach ($data as $index => $da) {

            }
            //echo  $da->Host;
            // Email server settings
            $mail->SMTPDebug =false;
            $mail->isSMTP();
            if($da->SMTPAuth==true){
            $mail->Host = ''.$da->Host.'';             //  smtp host
            $mail->SMTPAuth = $da->SMTPAuth;
            $mail->Username = ''.$da->Username.'';   //  sender username
            $mail->Password = ''.$da->Password.'';       // sender password
            $mail->SMTPSecure = ''.$da->SMTPSecure.''; 
            }                 // encryption - ssl/tls
            $mail->Port = ''.$da->port.'';                          // port - 587/465

            $mail->setFrom(''.$da->setFrom.'', ''.$da->name.'');
            $mail->addAddress($clientemailaddress);
           // $mail->addCC($request->emailCc);
           // $mail->addBCC($request->emailBcc);

            $mail->addReplyTo(''.$da->addReplyTo.'', ''.$da->name.'');

            /*if(isset($_FILES['emailAttachments'])) {
                for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }*/


            $mail->isHTML($da->isHTML);                // Set email content format to HTML

            $mail->Subject = $subject;
            $mail->Body    = $body;

            // $mail->AltBody = plain text version of email body;

            if( !$mail->send() ) {
              
           
                DB::insert("insert into email_logs (email,
                                                    email_body,
                                                    return_message,
                                                    email_setup_id,
                                                    email_status,
                                                    date_time,
                                                    user_id,
                                                    created_at) 
                                            values ('".$clientemailaddress."',
                                                    '". $body."',
                                                    '". $mail->ErrorInfo."',
                                                    '".$da->id."',
                                                    'false',
                                                    NOW(),
                                                    '".$user_id."',
                                                    NOW()
                                                )");
                return false;
            

            }
            else {

                DB::insert("insert into email_logs (email,
                                                    email_body,
                                                    return_message,
                                                    email_setup_id,
                                                    email_status,
                                                    date_time,
                                                    user_id,
                                                    created_at) 
                                            values ('".$clientemailaddress."',
                                                    '". $body."',
                                                    '". $mail->ErrorInfo."',
                                                    '".$da->id."',
                                                    'true',
                                                    NOW(),
                                                    '".$user_id."',
                                                    NOW()
                                                )");

               return true;

              
            }

        } catch (Exception $e) {
            return false;
            

        }
    }