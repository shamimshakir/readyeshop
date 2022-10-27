<?php
use Illuminate\Support\Facades\DB;
use Spatie\ImageOptimizer\OptimizerChainFactory;

function pick($table, $field, $cond, $val) {
    $tt = NULL;
    if ($cond == null) {
        $query = DB::table($table)
                ->select(DB::raw($field . ' AS name'));
    } else {
        $query = DB::table($table)
                ->select(DB::raw($field . ' AS name'));
        $query->where($cond, $val);
    }
    $data = $query->get();
    foreach ($data as $index => $da) {
        if ($tt == null) {
            $tt = $da->name;
        } else {
            $tt = $tt . '<BR>' . $da->name;
        }
    }
    return $tt;
}
function pickall($table, $cond, $val) {
    $tt = NULL;
    if ($cond == null) {
        $query = DB::table($table)
                ->select('*');
    } else {
        $query = DB::table($table)
                ->select('*');
        $query->where($cond, $val);
    }
    $data = $query->get();
    return $data;
}
function dcount( $table, $field, $cond) {
    //return $cond;
  if ($cond == null) {
        $query = DB::table($table)
                ->select(DB::raw($field . ' AS name'));
    } else {
        $query = DB::table($table)
                ->select(DB::raw($field . ' AS name'));

        foreach ($cond as $key => $value){
          $query->where($key, $value);  
        }            
    }
    $query = $query->get();
    $query = $query->count();
  return $query;
}
function dsum( $table, $field, $cond,$groupBy) {
    //return $cond;
  if ($cond == null) {
        $query = DB::table($table)
                ->select(DB::raw("SUM(".$field.") as name"));
    } else {
        $query = DB::table($table)
                ->select(DB::raw("SUM(".$field.") as name"));

        foreach ($cond as $key => $value){
          $query->where($key, $value);  
        }            
    }
    $query = $query->groupBy($groupBy);
    $query = $query->get();
    //$query = $query->count();
    $sum=0;
   foreach ($query as $index => $da) {
    $sum=$da->name;
   }
  return $sum;
}

function pick_array($table, $field, $cond, $val) {
    $tt = array();

    if ($cond == null) {

        $query = DB::table($table)
                ->select(DB::raw($field . ' AS name'));
    } else {
        $query = DB::table($table)
                ->select(DB::raw($field . ' AS name'));
        $query->where($cond, $val);
    }
    $data = $query->get();
    foreach ($data as $index => $da) {
        array_push($tt,$da->name);         
    }

    return $tt;
}


function createCombo( $ComboName, $TableName, $ID, $Name, $Condition,$val, $selectedValue ) {
  
  $query = DB::table($TableName)
  		  ->select(DB::raw($ID . ' AS ID,'.$Name . ' AS NAME'));
  	 if($Condition!=''){  
  	  $query->where($Condition, $val);
  	  }
  $data = $query->get();

$datas="<option value=''>Select a $ComboName</option>\n";
foreach ($data as $index => $da) {
        array_push($tt,$da->name); 
        if ( $da->ID == $selectedValue ){

		$datas .="<option value='".$da->ID."' selected>".$da->NAME."</option>\n";

        }else{
			$datas .="<option value='".$da->ID."' selected>".$da->NAME."</option>\n";
        }
    } 
    return $datas;
  
}



function ImageUpload($image,$location,$width=null,$height=null){
    
$final_path=$_SERVER['SERVER_NAME'].'/'.$location;
	if ( !file_exists( $final_path ) ) {
	    mkdir( $final_path, 0777, true );
	  }

	$input['imagename'] = rand(11111,99999).time().'.'.$image->getClientOriginalExtension();

	$destinationPath = public_path($final_path);

	if($width!='' && $height!=''){
    	$imgFile = Image::make($image->getRealPath());
    	$imgFile->resize($width, $height, function ($constraint) {
    		    $constraint->aspectRatio();
    		})->save($destinationPath.'/'.$input['imagename']);

    	$destinationPath = public_path($final_path);
        $image->move($destinationPath, $input['imagename']);

        $pathToImage=$destinationPath.$input['imagename'];
        $pathToOptimizedImage=$destinationPath.'1/'.$input['imagename'];


        $optimizerChain = OptimizerChainFactory::create();
        $result=$optimizerChain->optimize($pathToImage);
       
	}else{
        $image->move($destinationPath,  $input['imagename']);

        $pathToImage=$destinationPath.$input['imagename'];

        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize($pathToImage);
    }

	

	return $input['imagename'];

}




function convert_text($text) {
$t = $text;
$specChars = array(
    '!' => '%21',    '"' => '%22',
    '#' => '%23',    '$' => '%24',    '%' => '%25',
    '&' => '%26',    '\'' => '%27',   '(' => '%28',
    ')' => '%29',    '*' => '%2A',    '+' => '%2B',
    ',' => '%2C',    '-' => '%2D',    '.' => '%2E',
    '/' => '%2F',    ':' => '%3A',    ';' => '%3B',
    '<' => '%3C',    '=' => '%3D',    '>' => '%3E',
    '?' => '%3F',    '@' => '%40',    '[' => '%5B',
    '\\' => '%5C',   ']' => '%5D',    '^' => '%5E',
    '_' => '%5F',    '`' => '%60',    '{' => '%7B',
    '|' => '%7C',    '}' => '%7D',    '~' => '%7E',
    ',' => '%E2%80%9A',  ' ' => '%20'
);
foreach ($specChars as $k => $v) {
    $t = str_replace($k, $v, $t);
}
return $t;
}

function bind_to_template($replacements, $template){
    return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) 
    {
        return $replacements[$matches[1]];
    }, $template);
}


function createRandStr($length, $spChars = false){
        $alpha = 'abcdefghijklmnopqrstwvxyz';
        $alphaUp = strtoupper($alpha);
        $num = '12345678901234567890';
        $sp = '@/+.*-\$#!)[';
        $thread = $alpha.$alphaUp.$num;
        if ($spChars) $thread .= $sp;
        $str = '';
        for ($i = 0; $i < $length; $i++){
            $str .= $thread[mt_rand(0, strlen($thread)-1)];
        }
        return $str;

    } 

function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function writeLog($logName, $logData){
        file_put_contents('./log-'.$logName.date("j.n.Y").'.log',$logData,FILE_APPEND);
}
function stdToArray($obj){
  $reaged = (array)$obj;
  foreach($reaged as $key => &$field){
    if(is_object($field))$field = stdToArray($field);
  }
  return $reaged;
}


function envUpdate($domain,$key, $value)
    {
        $path = base_path('.env.'.$domain);

        if (file_exists($path)) {

            file_put_contents($path, str_replace(
                $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
            ));
        }
    }
?>
