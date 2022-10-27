<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class UserController extends Controller
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
        $users = User::with('status_d')->get();
        if($users) {
            return response()->json(["status" => "success", "error" => false, "count" => count($users),"data" => $users], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no user found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no userfound."], 404);
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
            "first_name" => "required",            
            "email" => "required|email|unique:users,email",
            "password" => "required|min:3",
            "phone" => "required|min:11",
            "user_profile_id" => "required",            
            "address" => "required",            
            "status" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'full_name' => $request->first_name . " ".$request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_profile_id' => $request->user_profile_id,
            'comp_address' => $request->comp_address,
            'address' => $request->address,
            'user_guide_show' => $request->user_guide_show,
            'company_name' => $request->company_name,
            'status' => $request->status,
            'user_id' => Auth::user()->id,
            'password' => Hash::make($request->password)
        ]);
       
            return response()->json(["status" => "success", "error" => false, "message" => "Success! User created."], 201);
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

        $users = User::with('status_d')->where('users.id', '=', $id)->get();
        if($users) {
            return response()->json(["status" => "success", "error" => false, "count" => count($users),"data" => $users], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no User found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no User found."], 404);
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
        $users = User::find($id);
        if($user!='' && $users){
            $validator = Validator::make($request->all(), [
                "first_name" => "required",                
                "email" => "required|email",                
                "phone" => "required|min:11",
                "user_profile_id" => "required",               
                "address" => "required",                
                "status" => "required",
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $users['first_name'] = $request->first_name;
            $users['last_name'] = $request->last_name;
            $users['email'] = $request->email;
            if($request->password!=''){
                $users['password'] =  Hash::make($request->password);
            }            
            $users['phone'] = $request->phone;
            $users['user_profile_id'] = $request->user_profile_id;
            $users['comp_address'] = $request->comp_address;
            $users['address'] = $request->address;
            $users['user_guide_show'] = $request->user_guide_show;
            $users['company_name'] = $request->company_name;
            $users['status'] = $request->status;
            $users->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! User  updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no User found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::find($id);
        if($users) {
            $users->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! user deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no User found."], 404);
    }





    /**
     * Register User
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            "first_name" => "required",
            "email" => "required",
            "password" => "required|min:3",
            "phone" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        $user = User::create([
            'first_name' => $request->first_name,            
            'full_name' => $request->first_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'user_profile_id' => '2',
            'status' =>'1',
            'user_guide_show' =>'1'
        ]);

        return response()->json(["status" => "success", "error" => false, "message" => "Success! User registered."], 201);
    }

    /**
     * User Login
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required|min:3"
        ]);

       if($validator->fails()) {
           return $this->validationErrors($validator->errors())->setStatusCode(422);
       }

        try {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('token')->accessToken;
                return response()->json(
                    [
                        "status" => "success",
                        "error" => false,
                        "users" =>$user,
                        "message" => "Success! you are logged in.",
                        "token" => $token,
                    ]
                );
            }
            return response()->json(["status" => "failed", "message" => "Failed! invalid credentials."], 404);
        }
        catch(Exception $e) {
            return response()->json(["status" => "failed", "message" => $e->getMessage()], 404);
        }
    }


    public function login_sso(Request $request) {
                 
        
        if($_SERVER["HTTP_APPKEY"]!='vKZQncFeciA2nzby7OtQQaqrnKyxdje4'){            
            return response()->json([
                "status" => "failed",
                "url" => "https://readyeshop.com/admin#/shop-clients", 
                "message" => "Invalid App key"
            ], 404);

        } 

        if($_SERVER["HTTP_SECRET"]!="l#]-;9/B@8Tth[wqmKY-(DZ'quwI5.R9Z?MhJnwLOJ8A4~Nw<U[5@Fp!IZ`:lkL"){
            return response()->json([
                "status" => "failed",
                "url" => "https://readyeshop.com/admin#/shop-clients", 
                "message" => "Invalid App Secret"
            ], 404);
        } 
        try {            
            $user = User::find('1');
            $token = $user->createToken('token')->accessToken;
            return array("users" =>$user,"token" => $token);
        }
        catch(Exception $e) {
            return response()->json(["status" => "failed", "message" => $e->getMessage()], 404);
        }
    }

    public function loginOthers(Request $request) { 
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://'.request()->getHttpHost().'/api/user',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$request->tocken.''
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return view('loginOthers',['user' => json_decode($response)]);    
    }

    /**
     * Logged User Data Using Auth Token
     *
     * @return void
     */
    public function user() {
        try {
            $user = Auth::user();
           
            $users = User::with('UserProfile','UserStatus')->find($user->id);

            return response()->json(["status" => "success", "error" => false, "data" => $users], 200);
        }
        catch(NotFoundHttpException $exception) {
            return response()->json(["status" => "failed", "error" => $exception], 401);
        }
    }

    public function change_password(Request $request) {

            $validator = Validator::make($request->all(), [           
                'password' => [
                                'required',
                                'string',
                                'min:10',             // must be at least 10 characters in length
                                'regex:/[a-z]/',      // must contain at least one lowercase letter
                                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                                'regex:/[0-9]/',      // must contain at least one digit
                                'regex:/[@$!%*#?&]/', // must contain a special character
                            ],
                'password_confirm' => 'required|same:password'  
            ]);

           if($validator->fails()) {
               return $this->validationErrors($validator->errors())->setStatusCode(422);
           }

        try {
            $user = Auth::user();
            $users = User::find($user->id);
            
            $users['password'] =  Hash::make($request->password);
            $users->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! User Password updated."], 201);
        }
        catch(NotFoundHttpException $exception) {
            return response()->json(["status" => "failed", "error" => $exception], 401);
        }
    }
    /**
    * Logout Auth User
    *
    * @param Request $request
    * @return void
    */
    public function logout() {
        if(Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! You are logged out."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! You are already logged out."], 403);
    }

    
}