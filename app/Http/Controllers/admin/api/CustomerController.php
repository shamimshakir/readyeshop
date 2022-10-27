<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;


class CustomerController extends Controller
{

      
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $user = Auth::user();
       if($user!=''){

       $customer=Customer::select("customers.id",
                                "customers.cl_pin",
                                "customers.cl_code",
                                "customers.surname",
                                "customers.firstname",
                                "customers.lastname",
                                "customers.address",
                                "customers.address1",
                                "customers.street",
                                "customers.city",
                                "customers.postal_code",
                                "customers.province",
                                "customers.country",
                                "customers.company",
                                "customers.phone",
                                "customers.fax",
                                "customers.email",
                                "customers.user_regdate",
                                "customers.user_last_login",
                                "customers.reward_point",
                                "customers.customer_type",
                                "customers.user_stat",
                                "customers.varified_status",
                                "customers.varified_by",
                                "customers.varified_date",
                                "customers.district",
                                "customers.varify_code",
                                "customers.google_code",
                                "customers.facebook_id",
                                "customers.thana",
                                "thanas.name as thana_name",
                                "districts.location as district_name",
                                "countries.name as countrie_name"
                        )
                        ->leftJoin("thanas", "thanas.id", "=", "customers.thana")
                        ->leftJoin("districts", "districts.id", "=", "customers.district")
                        ->leftJoin("countries", "countries.id", "=", "customers.country")
                        ->get();
        if($customer) {
            return response()->json(["status" => "success", "error" => false, "count" => count($customer),"data" => $customer], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no customer found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no customer found."], 404);
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
            "email" => "required_without:phone|nullable|unique:customers,email|email",
            "firstname" => "required",
            "address" => "required",
            "city"=>"required",
            "country"=>"required",
            "phone"=>"required_without:email|nullable|unique:customers,phone",
            "thana"=>"required",
            "cl_pin"=>"required" 
        ]);

        if($validator->fails()) {          
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $key = md5($request->email);
            $addKey = substr( md5( uniqid( rand(), 1 ) ), 3, 10 );
            $key = $key . $addKey;
            $customer = Customer::create([
                "cl_pin" => $request->cl_pin,
                "cl_code" => createRandStr(5),
                "surname" => $request->surname,
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "address" => $request->address,
                "address1" =>$request->address1,
                "street" =>$request->street,
                "city" =>$request->city,
                "postal_code" =>$request->postal_code,
                "province" =>$request->province,
                "country" =>$request->country,
                "phone" =>$request->phone,
                "fax" =>$request->fax,
                "email" =>$request->email,
                "user_stat" =>'1',
                "varified_status" =>'0',
                "varified_by" =>'0',
                "varified_date" =>NULL,
                "district" =>$request->city,
                "varify_code" =>$key,
                "thana" =>$request->thana,
                "user_regdate" =>date("Y-m-d H:i:s")
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! customer created."], 201);
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
        //$district = Auth::user()->districts->find($id);
        $user = Auth::user();
        if($user!=''){

            $customer=Customer::select("customers.id",
                                "customers.cl_pin",
                                "customers.cl_code",
                                "customers.surname",
                                "customers.firstname",
                                "customers.lastname",
                                "customers.address",
                                "customers.address1",
                                "customers.street",
                                "customers.city",
                                "customers.postal_code",
                                "customers.province",
                                "customers.country",
                                "customers.company",
                                "customers.phone",
                                "customers.fax",
                                "customers.email",
                                "customers.user_regdate",
                                "customers.user_last_login",
                                "customers.reward_point",
                                "customers.customer_type",
                                "customers.user_stat",
                                "customers.varified_status",
                                "customers.varified_by",
                                "customers.varified_date",
                                "customers.district",
                                "customers.varify_code",
                                "customers.google_code",
                                "customers.facebook_id",
                                "customers.thana",
                                "thanas.name as thana_name",
                                "districts.location as district_name",
                                "countries.name as countrie_name"
                        )
                        ->leftJoin("thanas", "thanas.id", "=", "customers.thana")
                        ->leftJoin("districts", "districts.id", "=", "customers.district")
                        ->leftJoin("countries", "countries.id", "=", "customers.country")
                        ->where('customers.id', '=', $id)
                        ->get();

        if($customer) {
            return response()->json(["status" => "success", "error" => false, "count" => count($customer), "data" => $customer], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no customer found."], 404);
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no customer found."], 404);
    }

    public function search($keyword)
    {
        //echo $keyword;
       
        $customer=Customer::select("customers.id",
                                "customers.cl_pin",
                                "customers.cl_code",
                                "customers.surname",
                                "customers.firstname",
                                "customers.lastname",
                                "customers.address",
                                "customers.address1",
                                "customers.street",
                                "customers.city",
                                "customers.postal_code",
                                "customers.province",
                                "customers.country",
                                "customers.company",
                                "customers.phone",
                                "customers.fax",
                                "customers.email",
                                "customers.user_regdate",
                                "customers.user_last_login",
                                "customers.reward_point",
                                "customers.customer_type",
                                "customers.user_stat",
                                "customers.varified_status",
                                "customers.varified_by",
                                "customers.varified_date",
                                "customers.district",
                                "customers.varify_code",
                                "customers.google_code",
                                "customers.facebook_id",
                                "customers.thana",
                                "thanas.name as thana_name",
                                "districts.location as district_name",
                                "countries.name as countrie_name"
                        )
                        ->leftJoin("thanas", "thanas.id", "=", "customers.thana")
                        ->leftJoin("districts", "districts.id", "=", "customers.district")
                        ->leftJoin("countries", "countries.id", "=", "customers.country")
                        ->where('customers.firstname', 'like',$keyword.'%')
                        ->orWhere('customers.phone', 'like',$keyword.'%')
                        ->orWhere('customers.email', 'like', $keyword.'%')
                        //->toSql();

                       ->get();
                       // print_r($customer);
                      //  exit;

       if($customer) {
           return response()->json(["status" => "success", "error" => false, "count" => count($customer), "data" => $customer], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no customer found."], 404);
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
       if($user!=''){
        $customer = Customer::find($id);
       
        if($customer) {
            $validator = Validator::make($request->all(), [                
                "email" => "required_without:phone",            
                "firstname" => "required",                
                "address" => "required",
                "city"=>"required",
                "country"=>"required", 
                "phone"=>"required_without:email", 
                "thana"=>"required" ,
                "cl_pin"=>"required" 
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
                $customer['surname'] = $request->surname;
                $customer['firstname'] = $request->firstname;
                $customer['lastname'] = $request->lastname;
                $customer['address'] = $request->address;
                $customer['address1'] =$request->address1;
                $customer['street'] =$request->street;
                $customer['city'] =$request->city;
                $customer['postal_code'] =$request->postal_code;
                $customer['province'] =$request->province;
                $customer['country'] =$request->country;                
                $customer['phone'] =$request->phone;
                $customer['fax'] =$request->fax;
                $customer['email'] =$request->email;                
                $customer['district'] =$request->district;                               
                $customer['thana'] =$request->thana;                 
                $customer['user_stat'] =$request->user_stat;
                $customer['cl_pin'] =$request->cl_pin;
                

            $customer->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! customer updated."], 201);
        }
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no customer found."], 404);
    }

    public function updateVerify(Request $request, $id)
    {
       $user = Auth::user();
       if($user!=''){
        $customer = Customer::find($id);
        
        
        if($customer) {
            $validator = Validator::make($request->all(), [                
                "varified_status" => "required"
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors());
            }

            $customer['varified_status'] = $request->varified_status;
            $customer['varified_by'] = Auth::user()->id;
            $customer['varified_date'] = date('Y-m-d H:i:s');

            $customer->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! customer updated."], 201);
        }
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no customer found."], 404);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        if($user!=''){
        $customer = Customer::find($id);
        
        
        if($customer) {
            $validator = Validator::make($request->all(), [                
                "user_stat" => "required"
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors());
            }

            $customer['user_stat'] = $request->user_stat;

            $customer->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! customer updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no customer found."], 404);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Auth::user()->customers->find($id);
        if($customer) {
            $customer->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! customer deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no customer found."], 404);
    }


    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "name" => "required",
            "address" => "required",
            "city"=>"required",
            "country"=>"required",
            "phone"=>"required",
            "thana"=>"required",
            "password"=>"required",
        ]);
        if($validator->fails()) {          
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            
            $key = md5($request->email);
            $addKey = substr( md5( uniqid( rand(), 1 ) ), 3, 10 );
            $key = $key . $addKey;
            if($request->password==null){
              $pass=  generateRandomString(5);
            }else{
              $pass=  $request->password;
            }
            $customer = Customer::create([
                "cl_pin" => $pass,
                "cl_code" => createRandStr(5),
                "firstname" => $request->name,
                "address" => $request->address,
                "city" =>$request->city,
                "postal_code" =>$request->postal_code,
                "country" =>$request->country,
                "phone" =>$request->phone,
                "email" =>$request->email,
                "user_stat" =>'1',
                "varified_status" =>'0',
                "varified_by" =>'0',
                "varified_date" =>NULL,
                "district" =>$request->city,
                "varify_code" =>$key,
                "thana" =>$request->thana,                
                "user_regdate" =>date("Y-m-d H:i:s")
            ]);

            $customer = customer::with('countries','districts','thanas','orders')->where('id',$customer->id)->first();
            $token=$customer->createToken('Personal Access Token')->accessToken;
            return response()->json(
                    [
                        "status" => "success",
                        "error" => false,
                        "users" =>$customer,
                        "message" => "Success! you are logged in.",
                        "token" => $token,
                    ]
                );
          
          
        }
        catch(Exception $exception) {
            return response()->json(["status" => "failed", "error" => $exception->getMessage()], 404);
        }
    }

    public function register_social(Request $request) {

        $validator = Validator::make($request->all(), [           
            "name" => "required",            
        ]);
        if($validator->fails()) {          
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            if($request->provider_id!=null){
                $hascustomers= pick('customers', 'count(id)', 'provider_id', $request->provider_id);
            }else{
                $hascustomers=0;
            }
            
            if($hascustomers>0){
                $customer = Customer::with('countries','districts','thanas','orders')
                ->where('provider_id',$request->provider_id)->get();
               //print_r($customer);
                if($customer) {
                    return response()->json(["status" => "success", "error" => false, "data" => $customer], 200);
                }

            } else{
            $key = md5($request->email);
            $addKey = substr( md5( uniqid( rand(), 1 ) ), 3, 10 );
            $key = $key . $addKey;
            if($request->password==null){
              $pass=  generateRandomString(5);
            }else{
              $pass=  $request->password;
            }
            $customer = Customer::create([
                "cl_pin" => $pass,
                "cl_code" => createRandStr(5),
                "firstname" => $request->name,
                "address" => $request->address,
                "city" =>$request->city,
                "postal_code" =>$request->postal_code,
                "country" =>$request->country,
                "phone" =>$request->phone,
                "email" =>$request->email,
                "user_stat" =>'1',
                "varified_status" =>'0',
                "varified_by" =>'0',
                "varified_date" =>NULL,
                "district" =>$request->city,
                "varify_code" =>$key,
                "thana" =>$request->thana,
                "provider" =>$request->provider,
                "provider_id" =>$request->provider_id,
                "avatar" =>$request->avatar,
                "access_token" =>$request->access_token,
                "user_regdate" =>date("Y-m-d H:i:s")
            ]);
            
            $customer = customer::with('countries','districts','thanas','orders')->where('id',$customer->id)->first();
            $token=$customer->createToken('Personal Access Token')->accessToken;
            return response()->json(
                    [
                        "status" => "success",
                        "error" => false,
                        "users" =>$customer,
                        "message" => "Success! you are logged in.",
                        "token" => $token,
                    ]
                );
            }
        }
        catch(Exception $exception) {
            return response()->json(["status" => "failed", "error" => $exception->getMessage()], 404);
        }
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            "email" => "required",            
            "password" => "required|min:3"
        ]);
        if($validator->fails()) {          
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
        if(customer::where('email',$request->email)->count() <= 0 ) return response()->json(["status" => "failed", "message" => "Email number does not exist"], 400);
        $customer = customer::where('email',$request->email)->first();
        if($request->password===$customer->cl_pin){    
        $token=$customer->createToken('Personal Access Token')->accessToken;
            return response()->json(
                    [
                        "status" => "success",
                        "error" => false,
                        "users" =>$customer,
                        "message" => "Success! you are logged in.",
                        "token" => $token,
                    ]
                );
        }else{    
            return response()->json(["status" => "failed", "message" => "Failed! invalid credentials."], 404);
        }
        }
        catch(Exception $e) {
            return response()->json(["status" => "failed", "message" => $e->getMessage()], 404);
        }
    }

    public function login_social(Request $request) {
        $validator = Validator::make($request->all(), [
            "password" => "required",
            "provider_id" => "required",
        ]);

        if($validator->fails()) {          
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {

        if(customer::where('provider_id',$request->provider_id)->count() <= 0 ) return response()->json(["status" => "failed", "message" => "Login Fail"], 400);

        $customer = customer::where('provider_id',$request->provider_id)->first();

        if($request->password===$customer->cl_pin){    
        $token=$customer->createToken('Personal Access Token')->accessToken;
            return response()->json(
                    [
                        "status" => "success",
                        "error" => false,
                        "users" =>$customer,
                        "message" => "Success! you are logged in.",
                        "token" => $token,
                    ]
                );
        }else{    
            return response()->json(["status" => "failed", "message" => "Failed! invalid credentials."], 404);
        }
        }
        catch(Exception $e) {
            return response()->json(["status" => "failed", "message" => $e->getMessage()], 404);
        }
    }

    public function logout() {
        if(Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! You are logged out."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! You are already logged out."], 403);
    }

    public function getcustomerdata(Request $request)
    {
        $id = Auth::id();
       $customer = Auth::user()->with('countries','districts','thanas','orders')->find($id);
       //print_r($customer);
        if($customer) {
            return response()->json(["status" => "success", "error" => false, "data" => $customer], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no customer found."], 404);    
    }

    public function getcustomer(Request $request)
    {
        $id = Auth::id();
       $customer = Auth::user()->find($id);
       //print_r($customer);
        if($customer) {
            return response()->json(["status" => "success", "error" => false, "data" => $customer], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no customer found."], 404);    
    }

    public function custupdate(Request $request)
    {
       $id = Auth::id();
       
       if($id!=''){
       $customer = Auth::user()->find($id);
       
        if($customer) {
            $validator = Validator::make($request->all(), [                
                "email" => "required",            
                "firstname" => "required",                
                "address" => "required",
                "city"=>"required",
                "country"=>"required", 
                "phone"=>"required", 
                "thana"=>"required" 
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }                
            $customer['firstname'] = $request->firstname;
            $customer['address'] = $request->address;
            $customer['country'] =$request->country;                
            $customer['phone'] =$request->phone;
            $customer['email'] =$request->email;                
            $customer['district'] =$request->city;                               
            $customer['thana'] =$request->thana; 
            $customer->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! customer updated."], 201);
        }
    }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no customer found."], 404);
    }
}
