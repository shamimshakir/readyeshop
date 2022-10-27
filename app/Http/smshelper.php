<?php
use Illuminate\Support\Facades\DB;

function SmsSendSystem( $mobile, $smsbody,$user_id, $sms_id = NULL ) {
 
  $usein = pick('parameters', 'parameter_status', 'parameter_name', 'nextech_sms');
  $sms_id = pick( "sms_setups", "id", "status", "1" );
  $has = pick( "sms_allocations", "current_ammount", "id", "1" );

  $lengths = strlen( $smsbody ) / 60;
  if ( $usein == 1 ) {
    if ( $has < $lengths ) {
      die;
    }
  }
  if ( NULL === $sms_id ) {
    $sms_id = 1;
  }
  if ( $sms_id <= 0 ) {
    echo 'No sms provider active';
    die;
  }

  $query = DB::table('sms_setups');
  if($sms_id!=''){
      $query->where('id',$sms_id);
  }else{
      $query->where('status','1');
  }
  $datas = $query->get();
  foreach ($datas as $index => $da) {

  }
  $url = $da->sms_url;

  $values = explode( ',', $da->submit_param );
  $data=array();
  foreach ( $values as $value ) {
    $nval = explode( '=', $value );
    $data[$nval[ 0 ]]=$nval[ 1 ];
  }

  $length = strlen( $mobile );


  if ( $mobile != "" && $length > 10 ) {
    $url = $url;
 $fields = $data;
 
    if ( $da->type == 'get' ) {
     // $fields_string =http_build_query($data);
      $fields_string ='';
     
      foreach ( $fields as $key => $value ) {
        $fields_string .= $key . '=' . $value . '&';
      }
      $fields_string = rtrim( $fields_string, '&' );
      
      $furl = $url . '?' . $fields_string;
      $smsbody = preg_replace( "/\r|\n/", "", convert_text( $smsbody ) );
      $furl = bind_to_template( array( 'mobile' => $mobile, 'smsbody' => $smsbody ), $furl );

      $ch = curl_init( $furl );
      curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      $result = curl_exec( $ch );
      if ( $result === false ) {
        //return 'Curl error: ' . curl_error($ch);
        $return_val = serialize( $result );
        DB::insert("INSERT INTO sms_logs (`number`, `sms_body`, `return_message`, `sms_setup_id`, `user_id`, sms_status, created_at) VALUES ('" . $mobile . "','" . $smsbody ."','" . $return_val . "','" . $sms_id . "','" . $user_id . "','false',NOW())" );
        return false;
      } else {
        // return 'Operation completed without any errors';
        $return_val = serialize( $result );
        DB::insert("INSERT INTO sms_logs (`number`, `sms_body`, `return_message`, `sms_setup_id`, `user_id`, sms_status, created_at) VALUES ('" . $mobile . "','" . $smsbody ."','" . $return_val . "','" . $sms_id . "','" . $user_id . "','true',NOW())" );
        ///If use internal Api 
        if ( $usein == 1 ) {
          DB::statement("UPDATE
						  `tbl_sms_allocation`
						SET
						  `current_ammount` =current_ammount-$lengths
						WHERE
						  `id` = '1'");
        }


        return true;
      }
      //close connection
      curl_close( $ch );
    } elseif ( $da->type == 'post' ) {
      $fields = bind_to_template( array( 'mobile' => $mobile, 'smsbody' => $smsbody ), $fields );

      $payload = json_encode( $fields );
      $ch = curl_init();
      curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
      curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
      curl_setopt( $ch, CURLOPT_URL, $url );
      curl_setopt( $ch, CURLOPT_HEADER, 0 );
      curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
      curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
      curl_setopt( $ch, CURLOPT_POST, 1 );
      curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );


      curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen( $payload ) ) );
      //Execute CURL
      $result = curl_exec( $ch );

      if ( $result === false ) {
        $return_val = serialize( $result );
        DB::insert("INSERT INTO sms_logs (`number`, `sms_body`, `return_message`, `sms_setup_id`, `user_id`, sms_status, created_at) VALUES ('" . $mobile . "','" . $smsbody . "','" . $return_val . "','" . $sms_id . "','" . $user_id . "','false',NOW())" );
        return false;
        //return 'Curl error: ' . curl_error( $ch );
      } else {
        $return_val = serialize( $result );
        DB::insert("INSERT INTO sms_logs (`number`, `sms_body`, `return_message`, `sms_setup_id`, `user_id`, sms_status, created_at) VALUES ('" . $mobile . "','" . $smsbody . "','" . $return_val . "','" . $sms_id . "','" . $user_id . "','true',NOW())" );
        if ( $usein == 1 ) {
         DB::statement("UPDATE
						  `tbl_sms_allocation`
						SET
						  `current_ammount` =current_ammount-$lengths
						WHERE
						  `id` = '1'");
        }
        return true;
        //return 'Operation completed without any errors';
      }
      curl_close( $ch );
    }
  }
}