<?php

namespace App\Http\Controllers\admin\api;

use App\Models\CompanySetup;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class CompanySetupController extends Controller
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
        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        if($companysetup) {
            return response()->json(["status" => "success", "error" => false,'url'=>$compurl, "count" => count($companysetup),"data" => $companysetup], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no companysetup found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no companysetup found."], 404);
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
            "company_name" => "required|min:3|unique:company_setups,company_name",
            "comp_address" => "required",
            "contact_email" => "required",
            "contact_phone" => "required",
            "district" => "required",
            "thana" => "required",
            "currency" => "required",
            "theme" => "required",
            "brand_filtering" => "required",
            "color_filtering" => "required",
            "price_filtering" => "required",
            "business_type_id" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $favicon=ImageUpload($request->file('favicon'),'images/company/');
            $logo=ImageUpload($request->file('logo'),'images/company/');
            $CompanySetup = CompanySetup::create([
                "company_name" => $request->company_name,
                "website_slogan" => $request->website_slogan,
                "website_url" => $request->website_url,
                "comp_address" => $request->comp_address,
                "favicon" => $favicon,
                "logo" => $logo,
                "contact_email" => $request->contact_email,
                "contact_phone" => $request->contact_phone,
                "contact_map_location" => $request->contact_map_location,
                "district" => $request->district,
                "currency" => $request->currency,
                "currency" => $request->currency,
                "brand_filtering" => $request->brand_filtering,
                "color_filtering" => $request->color_filtering,
                "price_filtering" => $request->price_filtering,
                "business_type_id" => $request->business_type_id,
                "thana" => $request->thana,
                "themecolor" => $request->themecolor,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Company created."], 201);           
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
        //
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
        $companysetup = CompanySetup::find($id);

        if($user!='' && $companysetup){
            $validator = Validator::make($request->all(), [
                "company_name" => "required",
                "comp_address" => "required",
                "contact_email" => "required",
                "contact_phone" => "required",
                "district" => "required",
                "thana" => "required",
                "currency" => "required",
                "theme" => "required",
                "brand_filtering" => "required",
                "color_filtering" => "required",
                "price_filtering" => "required",
                "business_type_id" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            if($request->file('favicon')!=''){ 
               $favicon=ImageUpload($request->file('favicon'),'images/company/');
               $companysetup['favicon'] = $favicon;
            }
            if($request->file('logo')!=''){ 
               $logo=ImageUpload($request->file('logo'),'images/company/');
               $companysetup['logo'] = $logo;
            }
            $companysetup['company_name'] = $request->company_name;
            $companysetup['website_slogan'] = $request->website_slogan;
            $companysetup['website_url'] = $request->website_url;
            $companysetup['comp_address'] = $request->comp_address;
            $companysetup['contact_email'] = $request->contact_email;
            $companysetup['contact_phone'] = $request->contact_phone;
            $companysetup['contact_map_location'] = $request->contact_map_location;
            $companysetup['district'] = $request->district;
            $companysetup['thana'] = $request->thana;
           $companysetup['currency'] = $request->currency;
           $companysetup['theme'] = $request->theme;
           $companysetup['brand_filtering'] = $request->brand_filtering;
           $companysetup['color_filtering'] = $request->color_filtering;
           $companysetup['price_filtering'] = $request->price_filtering;
           $companysetup['business_type_id'] = $request->business_type_id;
           $companysetup['themecolor'] = $request->themecolor;
            $companysetup->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Company updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Company found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function param(Request $request)
    {

        $compurl= url($_SERVER['SERVER_NAME']).'/images/company/';
        $companysetup = CompanySetup::with('currencys','themes')->get();
        
        if($companysetup) {
             return response()->json(["status" => "success", "error" => false,'url'=>$compurl, "count" => count($companysetup),"data" => $companysetup], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
