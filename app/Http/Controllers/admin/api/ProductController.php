<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductImage;
use App\Models\ProductActiveTag;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Http\helper;
use Image;

class ProductController extends Controller
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
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';
        $product = Product::with('Category','Brand','Unit','Status','productcolors','productsizes','productimages','productactivetags')->get();
        if($product) {
            return response()->json(["status" => "success", "error" => false, "count" => count($product),'url'=>$pdimageurl,"data" => $product], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
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
                "pd_name"=> "required|min:3|unique:products,pd_name",
                "category_id"=> "required",
                "pd_price"=> "required |  min:1",
                "pd_qty"=> "min:0",
                "hst"=> "min:0",
                "pd_thumbnail"=> "required|mimes:jpeg,png,jpg,gif,svg|max:300",
                "product_highlight"=> "required"
        ]);


        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {

            $thumbnail_image=ImageUpload($request->file('pd_thumbnail'),'images/product/',736,1000);
            $product = Product::create([
                "pd_name" => ($request->pd_name==null) ? '' : $request->pd_name,
                "category_id" =>($request->category_id==null) ? '' : $request->category_id,
                "brand_id" => ($request->brand_id==null) ? '' : $request->brand_id,
                "unit_type" => $request->unit_type,
                "pd_price" => $request->pd_price,
                "pd_code" => ($request->pd_code==null) ? '' : $request->pd_code, 
                "prod_type" => $request->prod_type,
                "hst" => $request->hst,
                "reward_point" => $request->reward_point,
                "pd_prev_price" => $request->pd_prev_price,
                "pd_qty" => $request->pd_qty,
                "popular_stat" => $request->popular_stat,
                "pd_status" => $request->pd_status,
                "upsstat" => $request->upsstat,
                "new_stat" => $request->new_stat,
                "product_detail" => ($request->product_detail==null) ? '' : $request->product_detail,
                "product_specification" => ($request->product_specification==null) ? '' : $request->product_specification,
                "product_warranty" => ($request->product_warranty==null) ? '' : $request->product_warranty,
                "feature_stat" => $request->feature_stat,
                "pd_thumbnail" => $thumbnail_image,
                "onsale_stat" => $request->onsale_stat,
                "color_apply" => $request->color_apply,
                "size_apply" => $request->size_apply,
                "meta_keyword" => ($request->meta_keyword==null) ? '' : $request->meta_keyword,
                "meta_description" =>($request->meta_description==null) ? '' : $request->meta_description ,
                "product_highlight" => ($request->product_highlight==null) ? '' : $request->product_highlight,
                "video" => ($request->video==null) ? '' : $request->video,
                "warranties_status" => $request->warranties_status,
                "detail_status" => $request->detail_status,
                "specification_status" => $request->specification_status,                
                "product_filter_tag" => ($request->product_filter_tag==null) ? '' : $request->product_filter_tag,                
                "user_id" => Auth::user()->id
            ]);
            $product_id =  $product->id;


            if($request->color_apply==1){
                $colors=$request->colors;
                foreach($colors as $color){
                    $ProductColor = ProductColor::create([
                    "color_id" =>$color,
                    "product_id" => $product_id,
                    "user_id" => Auth::user()->id
                    ]);
                }
            }

            
            $producttags=$request->producttags;
            if (!empty($producttags)) {
                foreach($producttags as $producttag){
                    $Product_tag = ProductActiveTag::create([
                    "tagid" =>$producttag,
                    "product_id" => $product_id,
                    "user_id" => Auth::user()->id
                    ]);
                }
            }
            


            if($request->size_apply==1){
                $sizes=$request->sizes;
                foreach($sizes as $size){
                    $ProductSize = ProductSize::create([
                    "size_id" =>$size,
                    "product_id" => $product_id,
                    "user_id" => Auth::user()->id
                    ]);
                }
            }
            
            if(!empty($request->file('pro_img_name'))){
                $images= $request->file('pro_img_name');
                foreach($images as $image){
                    $image=ImageUpload( $image,'images/product/',736,1000);
                    $ProductSize = ProductImage::create([
                    "pro_img_name" =>$image,
                    "product_id" => $product_id,
                    "user_id" => Auth::user()->id
                    ]);
                }
            } 
            return response()->json(["status" => "success", "error" => false, "message" => "Success! Product created."], 201);
           
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
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';

        $product = Product::with('Category','Brand','Unit','Status','productcolors','productsizes','productimages','productactivetags')->where('products.id', '=', $id)->get();

        if($product) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl, "count" => count($product), "data" => $product], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }
    public function showbystatus($id)
    {
        $user = Auth::user();
        if($user!=''){
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';

        $product = Product::with('Category','Brand','Unit','Status','productcolors','productsizes','productimages','productactivetags')->where('products.pd_status', '=', $id)->get();

        if($product) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl, "count" => count($product), "data" => $product], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }
    public function showbycatagory($id)
    {
        $user = Auth::user();
        if($user!=''){
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';

        $product = Product::with('Category','Brand','Unit','Status','productcolors','productsizes','productimages','productactivetags')->where('products.category_id', '=', $id)->get();

        if($product) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl, "count" => count($product), "data" => $product], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }
    public function showbycatagoryandstatus($cat_id,$stat_id)
    {
        $user = Auth::user();
        if($user!=''){
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';

        $product = Product::with('Category','Brand','Unit','Status','productcolors','productsizes','productimages','productactivetags')->where('products.category_id', '=', $cat_id)->where('products.pd_status', '=', $stat_id)->get();

        if($product) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl, "count" => count($product), "data" => $product], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
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
        $product = Product::find($id);
        if($user!='' && $product){     
                
            $validator = Validator::make($request->all(), [                
                "pd_name"=> "required",
                "category_id"=> "required",             
                "pd_price"=> "required | min:0",   
                "product_highlight"=> "required",
                "hst"=> "min:0",
                "pd_qty"=> "min:0",
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
                if($request->file('pd_thumbnail')!=''){                    
                   $thumbnail_image=ImageUpload($request->file('pd_thumbnail'),'images/product/',736,1000);
                  $product['pd_thumbnail'] = $thumbnail_image;
                }              
               
                $product['pd_name'] = $request->pd_name;
                $product['category_id'] = $request->category_id;
                $product['brand_id'] = $request->brand_id;
                $product['pd_status'] = $request->pd_status;
                $product['unit_type'] = $request->unit_type;
                $product['pd_price'] = $request->pd_price;
                $product['pd_code'] = ($request->pd_code==null) ? '' : $request->pd_code;
                $product['prod_type'] = $request->prod_type;
                $product['hst'] = $request->hst;
                $product['reward_point'] = $request->reward_point;
                $product['pd_prev_price'] = $request->pd_prev_price;
                $product['pd_qty'] = $request->pd_qty;
                $product['popular_stat'] = $request->popular_stat;
                $product['upsstat'] = $request->upsstat;
                $product['new_stat'] = $request->new_stat;
                $product['product_detail'] = ($request->product_detail==null) ? '' : $request->product_detail;
                $product['product_specification'] = ($request->product_specification==null) ? '' : $request->product_specification;               
                $product['product_warranty'] =($request->product_warranty==null) ? '' : $request->product_warranty; 
                $product['feature_stat'] = $request->feature_stat;                
                $product['onsale_stat'] = $request->onsale_stat;
                $product['color_apply'] = $request->color_apply;
                $product['size_apply'] = $request->size_apply;
                $product['meta_keyword'] = $request->meta_keyword;
                $product['meta_description'] = ($request->meta_description==null) ? '' : $request->meta_description;
                $product['product_highlight'] = ($request->product_highlight==null) ? '' : $request->product_highlight;
                $product['video'] =  ($request->video==null) ? '' : $request->video;
                $product['warranties_status'] = $request->warranties_status;
                $product['detail_status'] = $request->detail_status;
                $product['specification_status'] = $request->specification_status;
                $product['product_filter_tag'] = ($request->product_filter_tag==null) ? '' : $request->product_filter_tag;
                
                $product->save();     

                if($request->color_apply==1){
                    $product_color = ProductColor::where('product_id', $id)->get(['id']);
                    if($product_color) {                     
                        ProductColor::destroy($product_color->toArray()); 
                    }
                    $colors=$request->colors;
                    if(isset($request->colors)){
                        if(count($colors)>0){
                            foreach($colors as $color){ 
                                if($color>0){                  
                                    $productcolor = ProductColor::create([
                                    "color_id" =>$color,
                                    "product_id" => $id,
                                    "user_id" => Auth::user()->id
                                    ]);
                                    }
                            }
                        }
                    }
                }

                if($request->size_apply==1){
                    $product_size = ProductSize::where('product_id', $id)->get(['id']);

                    if($product_size) {                     
                    ProductSize::destroy($product_size->toArray()); 
                    }
                    $sizes=$request->sizes;
                    if(isset($request->sizes)){
                        if(count($sizes)>0){
                            foreach($sizes as $size){
                                if($size>0){ 
                                    $productsize = ProductSize::create([
                                    "size_id" =>$size,
                                    "product_id" => $id,
                                    "user_id" => Auth::user()->id
                                    ]);
                                    }
                            }
                        }
                    }
                }   


                if(!empty($request->producttags)){
                    $product_tag = ProductActiveTag::where('product_id', $id)->get(['id']);

                    if($product_tag) {                     
                    ProductActiveTag::destroy($product_tag->toArray()); 
                    }
                    
                    $producttags=$request->producttags;
                    if(isset($request->producttags)){
                        if(count($producttags)>0){
                            foreach($producttags as $producttag){
                                if($producttag>0){ 
                                    $Product_tag = ProductActiveTag::create([
                                    "tagid" =>$producttag,
                                    "product_id" => $id,
                                    "user_id" => Auth::user()->id
                                    ]);
                                    }
                            }
                        }
                    }
                }
                

                if(!empty($request->file('pro_img_name'))){                   
                    $images= $request->file('pro_img_name');
                    foreach($images as $image){
                        $image=ImageUpload( $image,'images/product/',736,1000);
                        $productiamge = ProductImage::create([
                        "pro_img_name" =>$image,
                        "product_id" => $id,
                        "user_id" => Auth::user()->id
                        ]);
                    }
                } 
             return response()->json(["status" => "success", "error" => false, "message" => "Success! product updated."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no product found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Auth::user()->product->find($id);
        if($product) {
            $product->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! product deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no product found."], 404);
    }

    public function delete_destroy($imgid,$image)
    {
        $ProductImage = ProductImage::find($imgid);
        if($ProductImage) {
            $ProductImage->delete();
            $image_path = "images/product/".$image;
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            return response()->json(["status" => "success", "error" => false, "message" => "Success! product image deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no product image found."], 404);
    }

    public function productdetails(Request $request)
    {
        
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';

        $product = Product::with('Category','Brand','Unit','Status','productcolors','productsizes','productimages','productactivetags','avgRating');
        if($request->name!=''){
            $product = $product->where('products.pd_name', '=', $request->name);
        }
        if($request->id>0){
            $product = $product->where('products.id', '=', $request->id);
        }     

        $product = $product->get();

        if($product) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl, "count" => count($product), "data" => $product], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product found."], 404);
    }

    public function param(Request $request)
    {
        //Log::info(json_encode($request->all()));
        $pdimageurl= url($_SERVER['SERVER_NAME']).'/images/product/';

        //$product =Product::select('*');
        $product =Product::with('Category','Brand','Unit','Status','productcolors','productsizes','productimages','productactivetags','reviewRows','avgRating');
        if($request->id>0){
            $product = $product->where('products.id', '=', $request->id);
        }
        if($request->popular>0){
            $product = $product->where('products.popular_stat', '=', $request->popular);
        }
        if($request->feature>0){
            $product = $product->where('products.feature_stat', '=', $request->feature);
        }
        if($request->upsstat>0){
            $product = $product->where('products.upsstat', '=', $request->upsstat);
        }
        if($request->onsale>0){
            $product = $product->where('products.onsale_stat', '=', $request->onsale);
        }

        if(!empty($request->color)){  
        $colors=$request->color;
         $cols=array_filter($request->color); 
         if(!empty($cols) ){ 
           $product = $product->whereHas('productcolors', function($query) use ($colors) {
                        $query->whereIn('product_colors.color_id', $colors  );
                    });
            }
        }

        if(!empty($request->size)){
            $sizes=$request->size;
            $sizs=array_filter($request->size); 
            if(!empty($sizs) ){ 
            $product = $product->whereHas('productsizes', function($query) use ($sizes) {
                $query->whereIn('product_sizes.size_id', $sizes  );
                    });
            }
        }   

        if(!empty($request->tag)){
            $tags=$request->tag;
            $tages=array_filter($request->tag); 
            if(!empty($tages) ){ 
            $product = $product->whereHas('productactivetags', function($query) use ($tags) {
                $query->whereIn('product_active_tags.tagid', $tags  );
                    });
            }
        }     

        if(!empty($request->category) ){
         $cate=array_filter($request->category); 
         if(!empty($cate) ){      
           $categories='';
            foreach($request->category as $cat){                
                $catids=pick_array('categories', 'id', 'cat_parent_id', $cat);
                foreach($catids as $scatid){
                    $categories= $scatid.",".$categories;
                    $tids=pick_array('categories', 'id', 'cat_parent_id', $scatid);
                    foreach($tids as $tid){
                        $categories= $tid.",".$categories;
                    }
                }
                $categories= $cat.",".$categories;
            } 
                $categories=trim($categories,','); 
                $catids_s = explode(',', $categories);
                $product = $product->whereIn('products.category_id', $catids_s );
            }
        }

        if(!empty($request->category_name) ){
         $cate=array_filter($request->category_name); 
         if(!empty($cate) ){                 
                $product = $product->whereHas('Category', function($query) use ($cate) {
                $query->whereIn('categories.cat_name', $cate  );
                    });
            }
        }

        
        if( !empty( $request->filter ) ) {

            for( $i=0; $i<=count($request->filter)-1; $i++ ) {
                $product = $product->orWhereRaw( "find_in_set('".$request->filter[$i]."' , product_filter_tag)" );
            }
        }

        if(!empty($request->brand)){

            $ban=array_filter($request->brand); 
            if(!empty($ban) ){ 
            $brands='';
            foreach($request->brand as $bran){
                 $brands= $bran.",".$brands;
            } 
           $brands=trim($brands,','); 
           
             //[$brands]
           $product = $product->whereIn('products.brand_id', $request->brand);
            }
        }
        if($request->code!=''){            
            $product = $product->where('products.pd_code', '=', $request->code);
        }
        if($request->name!=''){
            $product = $product->where('products.pd_name', 'LIKE', "%{$request->name}%");
        }
        if($request->status>0){
            $product = $product->Where('products.pd_status', '=', $request->status);
        }
        if($request->price_start>0 && $request->price_end>0){
            $product = $product->whereBetween('products.pd_price', [$request->price_start,$request->price_end]);
        }
        if($request->limit<=0){
            $limit = 10;
        }else{
           $limit =$request->limit;
        }
        
        //$product = $product->get();
        $product = $product->paginate($limit);

        if($product) {
            return response()->json(["status" => "success", "error" => false,'url'=>$pdimageurl, "count" => count($product),"data" => $product], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);        
    } 
            
}
