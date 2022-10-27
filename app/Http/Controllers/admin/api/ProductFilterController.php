<?php

namespace App\Http\Controllers\admin\api;

use App\Models\ProductFilter;
use App\Models\FilterOption;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductFilterController extends Controller
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
            $product_filters = ProductFilter::with('filteroptions','statuses')->get();
            if($product_filters) {
                return response()->json(["status" => "success", "error" => false, "count" => count($product_filters),"data" => $product_filters], 200);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Product Filter  found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Product Filter found."], 404);
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
            "name" => "required",
            "status" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            print_r($request->all());
            foreach($request->all_options as $i => $all_option ){
                print_r($all_option['option_name']);

            }
            $product_filters = ProductFilter::create([
                "name" =>($request->name==null) ? '' : $request->name,
                "name" =>($request->others_lan==null) ? '' : $request->others_lan,
                "status" => $request->status,
                "user_id" => Auth::user()->id
            ]);

            $filterid =  $product_filters->id;
            foreach($request->all_options as $i => $all_option ){                        
            $filteroption = FilterOption::create([
                "filter_id" =>$filterid,
                "option_name" => ($all_option['option_name']==null) ? '' : $all_option['option_name'],
                "others_option_name" => ($all_option['others_option_name']==null) ? '' : $all_option['others_option_name'],
                "user_id" => Auth::user()->id
                ]);
            }
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Product Filter created."], 201);
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
            $product_filters = ProductFilter::with('filteroptions','statuses')->where('product_filters.id', '=', $id)->get();
            if($product_filters) {
                return response()->json(["status" => "success", "error" => false, "count" => count($product_filters),"data" => $product_filters], 200);
            }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Product Filter  found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Product Filter found."], 404);
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
        $product_filters = ProductFilter::find($id);
        if($user!='' && $product_filters){
            $validator = Validator::make($request->all(), [
                "name" => "required",               
                "status" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $product_filters['name'] =($request->name==null) ? '' : $request->name;
            $product_filters['others_lan'] =($request->others_lan==null) ? '' : $request->others_lan;           
            $product_filters['status'] = $request->status;
            $product_filters->save();            

            foreach($request->all_options as $i => $all_option ){                
                $filter_options = FilterOption::find($all_option['id']);           
                if($filter_options){
                    $filter_options['option_name'] =($all_option['option_name']==null) ? '' : $all_option['option_name'];
                    $filter_options['others_option_name'] =($all_option['others_option_name']==null) ? '' : $all_option['others_option_name'];
                    $filter_options->save();     
                }else{
                   // $filter_options->delete();
                    $filteroptions = FilterOption::create([
                        "filter_id" =>$id,
                        "option_name" => ($all_option['option_name']==null) ? '' : $all_option['option_name'],
                        "others_option_name" => ($all_option['others_option_name']==null) ? '' : $all_option['others_option_name'],
                        "user_id" => Auth::user()->id
                    ]);
                }
            }

            return response()->json(["status" => "success", "error" => false, "message" => "Success! Product Filter updated."], 201);

      }
       return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Product Filter found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ProductFilter = Auth::user()->ProductFilter->find($id);
        if($ProductFilter) {
            $ProductFilter->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Product Filter deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no Product Filter found."], 404);
    }

    public function param(Request $request)
    {
        $product_filters = ProductFilter::with('filteroptions');
        if($request->name!=''){
            $product_filters = $product_filters->where('product_filters.name', '=', $request->name);
        }
        if($request->id>0){
            $product_filters = $product_filters->Where('product_filters.id', '=', $request->id);
        }
        if($request->status>0){
            $product_filters = $product_filters->Where('product_filters.status', '=', $request->status);
        }
        $product_filters = $product_filters->get();        
        if($product_filters) {
            return response()->json(["status" => "success", "error" => false, "count" => count($product_filters),"data" => $product_filters], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Meta found."], 404);        
    }

    public function productfilter_param(Request $request)
    {
        $product_filters = ProductFilter::with('filteroptions');
        if($request->name!=''){
            $product_filters = $product_filters->where('product_filters.name', '=', $request->name);
        }
        if($request->id>0){
            $product_filters = $product_filters->Where('product_filters.id', '=', $request->id);
        }
        if($request->status>0){
            $product_filters = $product_filters->Where('product_filters.status', '=', $request->status);
        }
        $product_filters = $product_filters->get();        
        if($product_filters) {
            return response()->json(["status" => "success", "error" => false, "count" => count($product_filters),"data" => $product_filters], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Meta found."], 404);        
    }

    public function param_selected(Request $request)
    {
         
        $tags = implode(', ', $request->selectedvalue);

        $product_filters = FilterOption::with('productfilter');
        if(!empty($request->selectedvalue) ){
         $tags=array_filter($request->selectedvalue); 
         if(!empty($tags) ){ 
                $product_filters = $product_filters->whereIn('id', $tags  );                   
            }
        }
        
        $product_filters = $product_filters->get();        
        if($product_filters) {
            return response()->json(["status" => "success", "error" => false, "count" => count($product_filters),"data" => $product_filters], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Meta found."], 404);        
    }
}
