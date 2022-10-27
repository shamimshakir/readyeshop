<?php

namespace App\Http\Controllers\admin\api;

use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;

class ProductReviewController extends Controller
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
        $productreviews = ProductReview::All();
        if($productreviews) {
            return response()->json(["status" => "success", "error" => false, "count" => count($productreviews),"data" => $productreviews], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ProductReview found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ProductReview found."], 404);
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
            "review" => "required",
            "rating" => "required",
            "pd_id" => "required",
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $has_order=dcount('order_items', 'pd_id', array('order_items.user_id'=>Auth::user()->id, 'order_items.pd_id' => $request->pd_id));

            if($has_order>0){
                $has_review=dcount('product_reviews', 'id', array('product_reviews.cust_id'=>Auth::user()->id, 'product_reviews.pd_id' => $request->pd_id));
                if($has_review<=0){
                    $productreviews = ProductReview::create([
                        "review" => $request->review,
                        "rating" => $request->rating,
                        "pd_id" => $request->pd_id,
                        "cust_id" => Auth::user()->id
                    ]);
                    return response()->json(["status" => "success", "error" => false, "message" => "Success! Thank you for your review."], 201);
                }else{
                    return response()->json(["status" => "success", "error" => true, "message" => "Fail! You already review this product"], 404);
                }
            }else{
                return response()->json(["status" => "success", "error" => true, "message" => "Fail! You can not review this product"], 404);
            }
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
        $productreviews = ProductReview::find($id);
        if($productreviews) {
            return response()->json(["status" => "success", "error" => false, "count" => count($productreviews),"data" => $productreviews], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ProductReview found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no ProductReview found."], 404);
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
        //
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
        $product_reviews = ProductReview::with('customer');
        if($request->pd_id>0){
            $product_reviews = $product_reviews->where('product_reviews.pd_id', '=', $request->pd_id);
        }  
        if($request->start_date!='' && $request->end_date!=''){
            $product_reviews = $product_reviews->whereBetween('product_reviews.created_at', [$request->start_date,$request->end_date]);
        }
        $product_reviews = $product_reviews->get();
        
        if($product_reviews) {
            return response()->json(["status" => "success", "error" => false, "count" => count($product_reviews),"data" => $product_reviews], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no product_reviews found."], 404);
        
        
    }
}
