<?php

namespace App\Http\Controllers\admin\api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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
       $category=Category::select("categories.id", 
                            "categories.cat_name",
                            "categories.cat_parent_id",
                            "categories.cat_description",
                            "categories.cat_name_others",
                            "categories.cat_description_others",
                            "categories.meta_keyword",
                            "categories.meta_description",
                            "categories.cat_image",
                            "categories.level_id",
                            "categories.act_status",
                            "categories.catagory_code",
                            "categories.sl",
                            "categories.user_id",
                            "categories.updated_at",
                            "parent_catagory.cat_name as parent_name"
                        ) 
                        ->leftJoin('categories as parent_catagory', 'parent_catagory.id', '=', 'categories.cat_parent_id')              
                        ->get();      
        if($category) {
            return response()->json(["status" => "success", "error" => false, "count" => count($category),"data" => $category], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no category found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no category found."], 404);
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
            "cat_name" => "required|min:3|unique:categories,cat_name",                 
            "level_id" => 'required',
            "act_status" => 'required'
        ]);
        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {           
           
            $category = Category::create([
                "cat_name" => $request->cat_name,
                "cat_parent_id" => $request->cat_parent_id,
                "cat_description" => $request->cat_description,
                "cat_name_others" => $request->cat_name_others,
                "cat_description" => $request->cat_description,
                "cat_description_others" => $request->cat_description_others,
                "meta_keyword" => $request->meta_keyword,
                "meta_description" => $request->meta_description,
                "level_id" => $request->level_id,
                "act_status" => $request->act_status,
                "catagory_code" => $request->catagory_code,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! category created."], 201);
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
        $category=Category::select("categories.id", 
                            "categories.cat_name",
                            "categories.cat_parent_id",
                            "categories.cat_description",
                            "categories.cat_name_others",
                            "categories.cat_description_others",
                            "categories.meta_keyword",
                            "categories.meta_description",
                            "categories.cat_image",
                            "categories.level_id",
                            "categories.act_status",
                            "categories.catagory_code",
                            "categories.sl",
                            "categories.user_id",
                            "categories.updated_at",
                            "parent_catagory.cat_name as parent_name"
                        ) 
                        ->leftJoin('categories as parent_catagory', 'parent_catagory.id', '=', 'categories.cat_parent_id')   
                        ->where('categories.id', '=', $id)                      
                        ->get();
        if($category) {
            return response()->json(["status" => "success", "error" => false, "count" => count($category), "data" => $category], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no aboutUs found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no aboutUs found."], 404);
    }

    
    public function showByParent($id)
    {
        $user = Auth::user();
        if($user!=''){
        $category=Category::select("categories.id", 
                            "categories.cat_name",
                            "categories.cat_parent_id",
                            "categories.cat_description",
                            "categories.cat_name_others",
                            "categories.cat_description_others",
                            "categories.meta_keyword",
                            "categories.meta_description",
                            "categories.cat_image",
                            "categories.level_id",
                            "categories.act_status",
                            "categories.catagory_code",
                            "categories.sl",
                            "categories.user_id",
                            "categories.updated_at",
                            "parent_catagory.cat_name as parent_name"
                        ) 
                        ->leftJoin('categories as parent_catagory', 'parent_catagory.id', '=', 'categories.cat_parent_id')   
                        ->where('categories.cat_parent_id', '=', $id)                      
                        ->get();
        if($category) {
            return response()->json(["status" => "success", "error" => false, "count" => count($category), "data" => $category], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no category found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no category found."], 404);
    }



    public function showByLevel($id)
    {
        $user = Auth::user();
        if($user!=''){
        $category=Category::select("categories.id", 
                            "categories.cat_name",
                            "categories.cat_parent_id",
                            "categories.cat_description",
                            "categories.cat_name_others",
                            "categories.cat_description_others",
                            "categories.meta_keyword",
                            "categories.meta_description",
                            "categories.cat_image",
                            "categories.level_id",
                            "categories.act_status",
                            "categories.catagory_code",
                            "categories.sl",
                            "categories.user_id",
                            "categories.updated_at",
                            "parent_catagory.cat_name as parent_name"
                        ) 
                        ->leftJoin('categories as parent_catagory', 'parent_catagory.id', '=', 'categories.cat_parent_id')   
                        ->where('categories.level_id', '=', $id)                      
                        ->get();
        if($category) {
            return response()->json(["status" => "success", "error" => false, "count" => count($category), "data" => $category], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no category found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no category found."], 404);
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
        $category = Category::find($id);
        if($user!='' && $category){     
                
            $validator = Validator::make($request->all(), [                
                "cat_name" => "required",
                                  
                "level_id" => 'required|Numeric',
                "act_status" => 'required|Numeric'
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }        
                
                $category['cat_name'] = $request->cat_name;
                $category['cat_parent_id'] = $request->cat_parent_id;
                $category['cat_description'] = $request->cat_description;
                $category['cat_name_others'] = $request->cat_name_others;
                $category['cat_description_others'] = $request->cat_description_others;
                $category['meta_keyword'] = $request->meta_keyword;
                $category['meta_description'] = $request->meta_description;
                $category['level_id'] = $request->level_id;
                $category['act_status'] = $request->act_status;
                $category['catagory_code'] = $request->catagory_code;
                $category->save();            
             return response()->json(["status" => "success", "error" => false, "message" => "Success! category updated."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no category found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category) {
            $category->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! category deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no category found."], 404);
    }


    public function param(Request $request)
    {

        $categories = Category::with('childrenCategories');
            if($request->parent_id>0){
                $categories = $categories->Where('categories.cat_parent_id', '=', $request->parent_id);
            }else{
                 $categories = $categories->Where('categories.cat_parent_id', '0');
            }
            if($request->id>0){
                $categories = $categories->where('categories.id', '=', $request->id);
            }
            if($request->level_id>0){
                $categories = $categories->Where('categories.level_id', '=', $request->level_id);
            }
            if($request->status>0){
                $categories = $categories->Where('categories.act_status', '=', $request->status);
            }
            
            $categories = $categories->get();

       if($categories) {
                return response()->json(["status" => "success", "error" => false, "data" => $categories], 200);
            }
                return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no category found."], 404);
    }

    public function paramFilter(Request $request)
    {

        $categories = DB::select(DB::raw("SELECT
                           categories.*
                        FROM
                            `products`
                        LEFT JOIN categories ON categories.id=products.category_id
                        GROUP BY products.category_id
                        ORDER BY categories.cat_name"));
           // $categories = $categories->get();
       if($categories) {
                return response()->json(["status" => "success", "error" => false, "data" => $categories], 200);
            }
                return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no category found."], 404);
    }


    public function getCatId(Request $request)
    {
        $categories = Category::with('childrenCategories_id');
            if($request->parent_id>0){
                $categories = $categories->Where('categories.cat_parent_id', '=', $request->parent_id);
            }else{
                 $categories = $categories->Where('categories.cat_parent_id', '0');
            }
            if($request->id>0){
                $categories = $categories->where('categories.id', '=', $request->id);
            }
            if($request->level_id>0){
                $categories = $categories->Where('categories.level_id', '=', $request->level_id);
            }
            if($request->status>0){
                $categories = $categories->Where('categories.act_status', '=', $request->status);
            }
            
            $categories = $categories->get('id');


            

       if($categories) {
                return response()->json(["status" => "success", "error" => false, "data" => $categories], 200);
            }
                return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no category found."], 404);
    }

    public function getCatName(Request $request)
    {

        $categories = Category::select('cat_name','cat_description','meta_keyword','meta_description');
            
            if($request->id>0){
                $categories = $categories->where('categories.id', '=', $request->id);
            }
            $categories = $categories->get();

       if($categories) {
                return response()->json(["status" => "success", "error" => false, "data" => $categories], 200);
            }
                return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no category found."], 404);
    }
}
