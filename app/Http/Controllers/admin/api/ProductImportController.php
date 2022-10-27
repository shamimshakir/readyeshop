<?php

namespace App\Http\Controllers\admin\api;
use Illuminate\Http\Request;
use App\Models\ProductImport;
use App\Imports\ProductsImport;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\helper;
use Image;

class ProductImportController extends Controller
{
   public function index()
    {
       $user = Auth::user();
       if($user!=''){
       
        $ProductsImport = ProductImport::select('*')->get();
        if($ProductsImport) {
            return response()->json(["status" => "success", "error" => false, "count" => count($ProductsImport),"data" => $ProductsImport], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }
   public function show($id)
    {
        $user = Auth::user();
        if($user!=''){
        

        $ProductsImport = ProductImport::select('*')->where('id', '=', $id)->get();

        if($ProductsImport) {
            return response()->json(["status" => "success", "error" => false, "count" => count($ProductsImport), "data" => $ProductsImport], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $product = ProductImport::find($id);
        if($user!='' && $product){     
                
            $validator = Validator::make($request->all(), [                
                "product_name"=> "required",
                "category"=> "required",
                "brand"=> "required",                
                "img"=> "required",                
                "highlight"=> "required",                
                "price"=> "required | min:0",
                "qty"=> "min:0", 
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }                          
               
            $product['product_name'] = $request->product_name;
            $product['category'] = $request->category;
            $product['brand'] = $request->brand;
            $product['price'] = $request->price;
            $product['qty'] = $request->qty;
            $product['img'] = $request->img;
            $product['highlight'] = $request->highlight;
            $product->save();     

                
             return response()->json(["status" => "success", "error" => false, "message" => "Success! product updated."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no product found."], 404);
    }




    public function import(Request $request)
    {
        
      $user = Auth::user();
      if($user!=''){

           $request->validate([
               'import_file' => 'required|file|mimes:xls,xlsx'
           ]);
           
           $path = $request->file('import_file');

           $data = Excel::import(new ProductsImport, $path);         
           return response()->json(["status" => "success", "error" => false,'message' => 'uploaded successfully'], 200);
      }
      return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }


    public function sysproduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        $products = ProductImport::select('*')->where('id','=',$request->id)->get();      
      
        foreach ($products as $index => $product) {
              if($product->product_name==null){
                  return response()->json(["status" => "failed", "error" => true,"message" => "Fail! Product Name Not Null."], 404);
              }
              $hasproduct=pick('products', 'count(id)', 'pd_name', $product->product_name );
              if($hasproduct>0){
                return response()->json(["status" => "failed", "error" => true,"message" => "Fail! Same Product here."], 404);
                
              }
              if($product->price==null){
                  return response()->json(["status" => "failed", "error" => true,"message" => "Fail! Product price Not Null."], 404);
              }
              if($product->qty==null){
                  return response()->json(["status" => "failed", "error" => true,"message" => "Fail! Product qty Not Null."], 404);
              }
              if($product->highlight==null){
                  return response()->json(["status" => "failed", "error" => true,"message" => "Fail! Product highlight Not Null."], 404);
              }
              $catgory_id=pick('categories', 'id', 'cat_name',$product->category );
              if($catgory_id==null){
                  return response()->json(["status" => "failed", "error" => true,"message" => "Fail! Category Not Match."], 404);
              }
              $brand_id=pick('brands', 'id', 'brand_display',$product->brand );
              if($brand_id==null){
                  return response()->json(["status" => "failed", "error" => true,"message" => "Fail! Brand Not Match."], 404);
              }

            $product = Product::create([
                "pd_name" => $product->product_name,
                "category_id" => $catgory_id,
                "brand_id" => $brand_id,                
                "pd_price" => $product->price,
                "pd_qty" => $product->qty,
                "product_highlight" => $product->highlight,
                "pd_thumbnail" => $product->img,
                "unit_type" => '6',
                "user_id" => Auth::user()->id
            ]);

            $products = ProductImport::find($request->id);
           
             if($products) {
                  $products->delete();
                  return response()->json(["status" => "success", "error" => false, "message" => "Success! product syn successfully."], 200);
              }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed to syn product ."], 404);
           
        }
       
    }
    public function sysproductbulk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array'
        ]);
        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        foreach ($request->ids as $id) {
            $products = ProductImport::select('*')->where('id','=',$id)->get();
            foreach ($products as $index => $product) {

              if($product->product_name==null){                
                  continue;   
              }

              $hasproduct=pick('products', 'count(id)', 'pd_name',$product->product_name );
              if($hasproduct>0){
               
                continue;
              }
              
              if($product->price==null){
                 continue;
              }
              if($product->qty==null){
                 continue;
              }
              if($product->highlight==null){
                 continue;
              }
              
              $catgory_id=pick('categories', 'id', 'cat_name',$product->category );
              if($catgory_id==null){
                 continue;
              }
              $brand_id=pick('brands', 'id', 'brand_display',$product->brand );
              if($brand_id==null){
                 continue;
              }
             
            $product = Product::create([
                "pd_name" => $product->product_name,
                "category_id" => $catgory_id,
                "brand_id" => $brand_id,                
                "pd_price" => $product->price,
                "pd_qty" => $product->qty,
                "product_highlight" => $product->highlight,
                "pd_thumbnail" => $product->img,
                "unit_type" => '6',
                "user_id" => Auth::user()->id
            ]);

            $product = ProductImport::find($id);           
             if($product) {
                  $product->delete();                 
              } 
            }
         }
          return response()->json(["status" => "success", "error" => false, "message" => "Success! product syn successfully."], 200);
    }

    public function delete_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
         $product = ProductImport::find($request->id);
         
          if($product) {
               $product->delete();
               return response()->json(["status" => "success", "error" => false, "message" => "Success! product delete successfully."], 200);
           }
         return response()->json(["status" => "failed", "error" => true, "message" => "Failed to delete product ."], 404);
           
   }
       
    
}
